<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Models;

use BaseCodeOy\Operations\Enums\OperationStatus;
use Illuminate\Database\Eloquent\Builder;

final class OperationBuilder extends Builder
{
    public function processing(): self
    {
        return $this->where('status', OperationStatus::PROCESSING);
    }

    public function passed(): self
    {
        return $this->where('status', OperationStatus::PASSED);
    }

    public function failed(): self
    {
        return $this->where('status', OperationStatus::FAILED);
    }
}
