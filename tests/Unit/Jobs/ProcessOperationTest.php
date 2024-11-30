<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Operations\Jobs\ProcessOperation;
use BaseCodeOy\Operations\Models\Operation;
use Tests\Fixtures\FailOperation;
use Tests\Fixtures\PassOperation;

covers(ProcessOperation::class);

it('can process an operation and pass', function (): void {
    // Arrange
    $operation = new PassOperation('2024_03_29_123456_operation.php');

    // Act
    ProcessOperation::dispatchSync($operation);

    // Assert
    $operation = Operation::query()->where('name', '2024_03_29_123456_operation.php')->firstOrFail();

    expect($operation->status->hasPassed())->toBeTrue();
});

it('can process an operation and fail', function (): void {
    // Arrange
    $operation = new FailOperation('2024_03_29_123456_operation.php');

    // Act
    ProcessOperation::dispatchSync($operation);

    // Assert
    $operation = Operation::query()->where('name', '2024_03_29_123456_operation.php')->firstOrFail();

    expect($operation->status->hasFailed())->toBeTrue();
});
