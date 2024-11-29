<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Pennant\Concerns;

use BaseCodeOy\Pennant\Models\FeatureFlagGroup;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFeatureFlagGroups
{
    public function featureFlagGroups(): MorphMany
    {
        return $this->morphMany(FeatureFlagGroup::class, 'model');
    }
}
