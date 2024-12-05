<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Enums;

enum OperationStatus: string
{
    case PROCESSING = 'processing';
    case PASSED = 'passed';
    case FAILED = 'failed';

    public function isProcessing(): bool
    {
        return $this === self::PROCESSING;
    }

    public function hasPassed(): bool
    {
        return $this === self::PASSED;
    }

    public function hasFailed(): bool
    {
        return $this === self::FAILED;
    }
}
