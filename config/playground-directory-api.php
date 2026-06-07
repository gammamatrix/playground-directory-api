<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Playground\Directory\Api\Policies\LocationPolicy;
use Playground\Directory\Api\Policies\SublocationPolicy;
use Playground\Directory\Models\Location;
use Playground\Directory\Models\LocationRevision;
use Playground\Directory\Models\Sublocation;
use Playground\Directory\Models\SublocationRevision;

/**
 * Playground: Directory API Configuration and Environment Variables
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_DIRECTORY_API_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, translations and views are loaded.
    |
    */

    'load' => [
        'policies' => (bool) env('PLAYGROUND_DIRECTORY_API_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_DIRECTORY_API_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_DIRECTORY_API_LOAD_TRANSLATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    |
    */

    'middleware' => [
        'default' => env('PLAYGROUND_DIRECTORY_API_MIDDLEWARE_DEFAULT', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_DIRECTORY_API_MIDDLEWARE_AUTH', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_DIRECTORY_API_MIDDLEWARE_GUEST', [
            'web',
            SubstituteBindings::class,
            EnsureFrontendRequestsAreStateful::class,
        ]),
    ],

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    |
    */

    'policies' => [
        Location::class => LocationPolicy::class,
        LocationRevision::class => LocationPolicy::class,
        Sublocation::class => SublocationPolicy::class,
        SublocationRevision::class => SublocationPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Revisions
    |--------------------------------------------------------------------------
    |
    |
    */

    'revisions' => [
        'optional' => (bool) env('PLAYGROUND_DIRECTORY_API_REVISIONS_OPTIONAL', false),
        'locations' => (bool) env('PLAYGROUND_DIRECTORY_API_REVISIONS_LOCATIONS', true),
        'sublocations' => (bool) env('PLAYGROUND_DIRECTORY_API_REVISIONS_SUBLOCATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'routes' => [
        'locations' => (bool) env('PLAYGROUND_DIRECTORY_API_ROUTES_LOCATIONS', true),
        'sublocations' => (bool) env('PLAYGROUND_DIRECTORY_API_ROUTES_SUBLOCATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Abilities
    |--------------------------------------------------------------------------
    |
    |
    */

    'abilities' => [
        'admin' => [
            'playground-directory-api:*',
        ],
        'manager' => [
            'playground-directory-api:location:*',
            'playground-directory-api:sublocation:*',
        ],
        'user' => [
            'playground-directory-api:location:view',
            'playground-directory-api:location:viewAny',
            'playground-directory-api:sublocation:view',
            'playground-directory-api:sublocation:viewAny',
        ],
    ],
];
