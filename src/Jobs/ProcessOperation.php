<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Jobs;

use BaseCodeOy\Operations\Enums\OperationStatus;
use BaseCodeOy\Operations\Models\Operation;
use BaseCodeOy\Operations\Operations\AbstractOneTimeOperation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class ProcessOperation implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly AbstractOneTimeOperation $oneTimeOperation,
    ) {
        if ($this->oneTimeOperation->getQueue() !== null) {
            $this->onQueue($this->oneTimeOperation->getQueue());
        }
    }

    public function handle(): void
    {
        $operation = Operation::create([
            'name' => $this->oneTimeOperation->getName(),
            'class' => $this->oneTimeOperation::class,
            'queue' => $this->oneTimeOperation->getQueue(),
            'status' => OperationStatus::PROCESSING,
            'started_at' => now(),
            'tags' => $this->oneTimeOperation->getTags(),
        ]);

        try {
            $this->oneTimeOperation->process();

            $this->markAsCompleted($operation);
        } catch (\Throwable $throwable) {
            $this->markAsFailed($operation, $throwable);

            $this->fail();
        }
    }

    private function markAsCompleted(Operation $operation): void
    {
        $operation->update([
            'status' => OperationStatus::PASSED,
            'failed_at' => null,
            'finished_at' => now(),
        ]);
    }

    private function markAsFailed(Operation $operation, \Throwable $throwable): void
    {
        $operation->update([
            'status' => OperationStatus::FAILED,
            'exception_message' => $throwable->getMessage(),
            'exception_trace' => $throwable->getTraceAsString(),
            'exception_trace_data' => $throwable->getTrace(),
            'failed_at' => now(),
            'finished_at' => now(),
        ]);
    }
}
