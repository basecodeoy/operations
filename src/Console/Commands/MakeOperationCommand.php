<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Console\Commands;

use Illuminate\Console\GeneratorCommand;

final class MakeOperationCommand extends GeneratorCommand
{
    protected $name = 'make:operation';

    protected $description = 'Create a new operation class';

    protected $type = 'Operation';

    #[\Override()]
    protected function getStub(): string
    {
        return __DIR__.'/stubs/operation.stub';
    }

    #[\Override()]
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Operations';
    }
}
