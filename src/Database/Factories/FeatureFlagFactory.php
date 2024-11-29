<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Pennant\Database\Factories;

use BaseCodeOy\Pennant\Models\FeatureFlag;
use Illuminate\Database\Eloquent\Factories\Factory;

final class FeatureFlagFactory extends Factory
{
    protected $model = FeatureFlag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'is_active' => true,
            'expires_at' => null,
        ];
    }
}
