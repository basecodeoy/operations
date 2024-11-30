<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Database\Factories;

use BaseCodeOy\Operations\Enums\OperationStatus;
use BaseCodeOy\Operations\Models\Operation;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OperationFactory extends Factory
{
    protected $model = Operation::class;

    #[\Override()]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'class' => $this->faker->word,
            'queue' => $this->faker->word,
            'tags' => $this->faker->words,
            'status' => $this->faker->randomElement([
                OperationStatus::PASSED,
                OperationStatus::FAILED,
                OperationStatus::PROCESSING,
            ]),
            'attempts' => $this->faker->numberBetween(1, 10),
            'payload' => [],
            'error' => null,
            'reserved_at' => null,
            'available_at' => null,
            'failed_at' => null,
            'started_at' => $this->faker->dateTime,
            'finished_at' => $this->faker->dateTime,
            'metadata' => [],
        ];
    }
}
