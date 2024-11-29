<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('operations', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('failed_operations', function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->string('name');
            $table->text('description')->nullable();
            $table->boolean('is_active');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }
};
