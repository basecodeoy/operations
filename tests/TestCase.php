<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests;

use BaseCodeOy\Crate\TestBench\AbstractTestCase;
use BaseCodeOy\Operations\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @internal
 */
abstract class TestCase extends AbstractTestCase
{
    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getEnvironmentSetUp($app): void
    {
        $app->config->set('app.key', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
        $app->config->set('tonic.servers', []);

        $app->config->set('cache.driver', 'array');

        $app->config->set('database.default', 'sqlite');
        $app->config->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app->config->set('mail.driver', 'log');

        $app->config->set('session.driver', 'array');

        $app->useStoragePath(\realpath(__DIR__.'/storage'));

        Schema::create('operations', function (Blueprint $blueprint): void {
            $blueprint->ulid('id')->primary();
            $blueprint->string('name')->unique();
            $blueprint->string('class');
            $blueprint->string('queue')->nullable();
            $blueprint->string('status');
            $blueprint->unsignedInteger('attempts')->nullable();
            $blueprint->unsignedInteger('reserved_at')->nullable();
            $blueprint->unsignedInteger('available_at')->nullable();
            $blueprint->timestamp('failed_at')->nullable();
            $blueprint->timestamp('started_at')->nullable();
            $blueprint->timestamp('finished_at')->nullable();
            $blueprint->longText('exception_message')->nullable();
            $blueprint->longText('exception_trace')->nullable();
            $blueprint->json('tags')->nullable();
            $blueprint->json('metadata')->nullable();
            $blueprint->timestamps();
        });
    }

    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application                            $app
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    #[\Override()]
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
