<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Pennant\Models;

use BaseCodeOy\Pennant\Database\Factories\FeatureFlagFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static FailedOperationBuilder query()
 */
final class FailedOperation extends Model
{
    use HasFactory;
    use HasUlids;

    public $guarded = ['id', 'created_at', 'updated_at'];

    public static function newFactory(): Factory
    {
        return FeatureFlagFactory::new();
    }

    public function newEloquentBuilder($query): FeatureFlagBuilder
    {
        return new FeatureFlagBuilder($query);
    }

    public function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
