<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Operations\Models;

use BaseCodeOy\Operations\Database\Factories\OperationFactory;
use BaseCodeOy\Operations\Enums\OperationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static OperationBuilder query()
 */
final class Operation extends Model
{
    use HasFactory;
    use HasUlids;

    public $guarded = ['id', 'created_at', 'updated_at'];

    public static function newFactory(): Factory
    {
        return OperationFactory::new();
    }

    #[\Override()]
    public function newEloquentBuilder($query): OperationBuilder
    {
        return new OperationBuilder($query);
    }

    #[\Override()]
    protected function casts(): array
    {
        return [
            'attempts' => 'integer',
            'available_at' => 'integer',
            'failed_at' => 'datetime',
            'finished_at' => 'datetime',
            'metadata' => 'array',
            'payload' => 'array',
            'reserved_at' => 'integer',
            'started_at' => 'datetime',
            'status' => OperationStatus::class,
            'tags' => 'array',
        ];
    }
}
