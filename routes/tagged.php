<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Directory\Models\Tagged;

/*
|--------------------------------------------------------------------------
| Directory API Routes: Tagged
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/directory/tagged',
    'middleware' => config('playground-directory-api.middleware.default'),
    'namespace' => '\Playground\Directory\Api\Http\Controllers',
], function () {

    // API

    Route::delete('/{tagged}', [
        'as' => 'playground.directory.api.tagged.destroy',
        'uses' => 'TaggedController@destroy',
    ])->whereUuid('tagged')->can('delete', 'tagged')->withTrashed();

    Route::post('/', [
        'as' => 'playground.directory.api.tagged.post',
        'uses' => 'TaggedController@store',
    ])->can('store', Tagged::class);
});
