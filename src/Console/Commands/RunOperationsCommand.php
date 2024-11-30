<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Console\Commands;

use BaseCodeOy\Operations\Jobs\ProcessOperation;
use BaseCodeOy\Operations\Models\Operation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

final class RunOperationsCommand extends Command
{
    protected $signature = 'operations:run {--tag= : Filter operations by tag}';

    protected $description = 'Run pending operations in timestamp order';

    public function handle(): void
    {
        $operations = collect(File::glob(base_path('operations/*.php')))
            ->map(fn ($path): array => [
                'path' => $path,
                'timestamp' => $this->extractTimestamp($path),
            ])
            ->sortBy('timestamp')
            ->values();

        $this->info(\sprintf('Found %d operations.', $operations->count()));

        foreach ($operations as $operation) {
            $this->processOperation($operation['path']);
        }
    }

    private function extractTimestamp(string $path): string
    {
        \preg_match('/(\d{4}_\d{2}_\d{2}_\d{6})/', $path, $matches);

        return $matches[1] ?? '000000_00_00_000000';
    }

    private function processOperation(string $path): void
    {
        $className = $this->getOperationClassName($path);
        $tag = $this->option('tag');
        $operationName = \basename($path);

        if (!\class_exists($className)) {
            $this->error('Operation class not found: '.$operationName);

            return;
        }

        $operation = new $className($operationName);

        if ($tag && $operation->getTag() !== $tag) {
            $this->line(\sprintf('Skipping %s (tag mismatch)', $operationName));

            return;
        }

        if (Operation::where('name', $operationName)->where('status', 'completed')->exists()) {
            $this->line(\sprintf('Skipping %s (already completed)', $operationName));

            return;
        }

        $this->info('Running operation: '.$operationName);

        $processOperation = new ProcessOperation($operation);

        if ($operation->isAsync()) {
            $this->line('Dispatching to queue: '.$operation->getQueue());

            dispatch($processOperation);
        } else {
            $processOperation->handle();

            $this->info('Completed operation: '.$operationName);
        }
    }

    private function getOperationClassName(string $path): string
    {
        $content = \file_get_contents($path);
        \preg_match('/namespace (.*?);/', $content, $matches);
        $namespace = $matches[1] ?? 'App\Operations';

        $className = \basename($path, '.php');

        return $namespace.'\\'.$className;
    }
}
