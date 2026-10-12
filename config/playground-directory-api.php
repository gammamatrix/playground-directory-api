<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Playground\Auth\Policies\Policy;
use Playground\Directory\Api\Policies\ContactPolicy;
use Playground\Directory\Api\Policies\LocationPolicy;
use Playground\Directory\Models\Contact;
use Playground\Directory\Models\ContactRevision;
use Playground\Directory\Models\Location;
use Playground\Directory\Models\LocationRevision;

/**
 * Playground: Directory API Configuration and Environment Variables
 *
 * @return array{
 *       about: bool,
 *       load: array{
 *           policies: bool,
 *           routes: bool,
 *           translations: bool
 *       },
 *       matrix: array{
 *           enabled: bool,
 *       },
 *       middleware: array{
 *           default: string|string[],
 *           auth: string|string[],
 *           guest: string|string[]
 *       },
 *       policies: array<
 *           class-string<Model>,
 *           class-string<Policy>
 *       >,
 *       revisions: array{
 *           options: bool,
 *           contacts: bool,
 *           locations: bool,
 *       },
 *       routes: array{
 *           contacts: bool,
 *           locations: bool,
 *       },
 *       cache: array{
 *           enable: bool,
 *           contact: bool,
 *           contact_store: string,
 *           contact_ttl: int,
 *           location: bool,
 *           location_store: string,
 *           location_ttl: int,
 *       },
 *       abilities: array<string, string[]>,
 *       sitemap: array{
 *            enable: bool,
 *            guest: bool,
 *            user: bool,
 *            view: string
 *       }
 *   }
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
    | Matrix
    |--------------------------------------------------------------------------
    |
    |
    */

    'matrix' => [
        'enabled' => (bool) env('PLAYGROUND_DIRECTORY_API_MATRIX_ENABLED', false),
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
        Contact::class => ContactPolicy::class,
        ContactRevision::class => ContactPolicy::class,
        Location::class => LocationPolicy::class,
        LocationRevision::class => LocationPolicy::class,
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
        'contacts' => (bool) env('PLAYGROUND_DIRECTORY_API_REVISIONS_CONTACTS', true),
        'locations' => (bool) env('PLAYGROUND_DIRECTORY_API_REVISIONS_LOCATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'routes' => [
        'contacts' => (bool) env('PLAYGROUND_DIRECTORY_API_ROUTES_CONTACTS', true),
        'locations' => (bool) env('PLAYGROUND_DIRECTORY_API_ROUTES_LOCATIONS', true),
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
            'playground-directory-api:contact:*',
            'playground-directory-api:location:*',
        ],
        'user' => [
            'playground-directory-api:contact:view',
            'playground-directory-api:contact:viewAny',
            'playground-directory-api:location:view',
            'playground-directory-api:location:viewAny',
        ],
    ],
];
