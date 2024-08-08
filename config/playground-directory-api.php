<?php
/**
 * Playground
 */

declare(strict_types=1);

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
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_DIRECTORY_API_MIDDLEWARE_AUTH', [
            'web',
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_DIRECTORY_API_MIDDLEWARE_GUEST', [
            'web',
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
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
        Playground\Directory\Models\Location::class => Playground\Directory\Api\Policies\LocationPolicy::class,
        Playground\Directory\Models\LocationRevision::class => Playground\Directory\Api\Policies\LocationPolicy::class,
        Playground\Directory\Models\Sublocation::class => Playground\Directory\Api\Policies\SublocationPolicy::class,
        Playground\Directory\Models\SublocationRevision::class => Playground\Directory\Api\Policies\SublocationPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Revisions
    |--------------------------------------------------------------------------
    |
    |
    */

    'revisions' => [
        'optional' => (bool) env('PLAYGROUND_DIRECTORY_API_ROUTES_OPTIONAL', false),
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
        'locations' => (bool) env('PLAYGROUND_DIRECTORY_API_LOCATIONS', true),
        'sublocations' => (bool) env('PLAYGROUND_DIRECTORY_API_SUBLOCATIONS', true),
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
