<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Directory\Api;

/**
 * \Tests\Unit\Playground\Directory\Api\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\ServiceProvider::class,
            \Playground\Auth\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
            \Playground\Directory\ServiceProvider::class,
            \Playground\Directory\Api\ServiceProvider::class,
            \Laravel\Sanctum\SanctumServiceProvider::class,
        ];
    }
}
