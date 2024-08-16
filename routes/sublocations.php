<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Directory API Routes: Sublocation
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/directory/sublocation',
    'middleware' => config('playground-directory-api.middleware.default'),
    'namespace' => '\Playground\Directory\Api\Http\Controllers',
], function () {

    Route::get('/{sublocation:slug}', [
        'as' => 'playground.directory.api.sublocations.slug',
        'uses' => 'SublocationController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/directory/sublocations',
    'middleware' => config('playground-directory-api.middleware.default'),
    'namespace' => '\Playground\Directory\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.directory.api.sublocations',
        'uses' => 'SublocationController@index',
    ])->can('index', Playground\Directory\Models\Sublocation::class);

    Route::post('/index', [
        'as' => 'playground.directory.api.sublocations.index',
        'uses' => 'SublocationController@index',
    ])->can('index', Playground\Directory\Models\Sublocation::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.directory.api.sublocations.create',
        'uses' => 'SublocationController@create',
    ])->can('create', Playground\Directory\Models\Sublocation::class);

    Route::get('/edit/{sublocation}', [
        'as' => 'playground.directory.api.sublocations.edit',
        'uses' => 'SublocationController@edit',
    ])->whereUuid('sublocation')->can('edit', 'sublocation');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.directory.api.sublocations.go',
    //     'uses' => 'SublocationController@go',
    // ]);

    Route::get('/{sublocation}', [
        'as' => 'playground.directory.api.sublocations.show',
        'uses' => 'SublocationController@show',
    ])->whereUuid('sublocation')->can('detail', 'sublocation');

    Route::get('/{sublocation}/revisions', [
        'as' => 'playground.directory.api.sublocations.revisions',
        'uses' => 'SublocationController@revisions',
    ])->whereUuid('sublocation')->can('revisions', 'sublocation');

    Route::post('/{sublocation}/revisions', [
        'uses' => 'SublocationController@revisions',
    ])->whereUuid('sublocation')->can('revisions', 'sublocation');

    Route::get('/revision/{sublocation_revision}', [
        'as' => 'playground.directory.api.sublocations.revision',
        'uses' => 'SublocationController@revision',
    ])->whereUuid('sublocation')->can('viewRevision', 'sublocation_revision');

    Route::put('/revision/{sublocation_revision}', [
        'as' => 'playground.directory.api.sublocations.revision.restore',
        'uses' => 'SublocationController@restoreRevision',
    ])->whereUuid('sublocation_revision')->can('restoreRevision', 'sublocation_revision');

    // API

    Route::put('/lock/{sublocation}', [
        'as' => 'playground.directory.api.sublocations.lock',
        'uses' => 'SublocationController@lock',
    ])->whereUuid('sublocation')->can('lock', 'sublocation');

    Route::delete('/lock/{sublocation}', [
        'as' => 'playground.directory.api.sublocations.unlock',
        'uses' => 'SublocationController@unlock',
    ])->whereUuid('sublocation')->can('unlock', 'sublocation');

    Route::delete('/{sublocation}', [
        'as' => 'playground.directory.api.sublocations.destroy',
        'uses' => 'SublocationController@destroy',
    ])->whereUuid('sublocation')->can('delete', 'sublocation')->withTrashed();

    Route::put('/restore/{sublocation}', [
        'as' => 'playground.directory.api.sublocations.restore',
        'uses' => 'SublocationController@restore',
    ])->whereUuid('sublocation')->can('restore', 'sublocation')->withTrashed();

    Route::post('/', [
        'as' => 'playground.directory.api.sublocations.post',
        'uses' => 'SublocationController@store',
    ])->can('store', Playground\Directory\Models\Sublocation::class);

    // Route::put('/', [
    //     'as' => 'playground.directory.api.sublocations.put',
    //     'uses' => 'SublocationController@store',
    // ])->can('store', Playground\Directory\Models\Sublocation::class);
    //
    // Route::put('/{sublocation}', [
    //     'as' => 'playground.directory.api.sublocations.put.id',
    //     'uses' => 'SublocationController@store',
    // ])->whereUuid('sublocation')->can('update', 'sublocation');

    Route::patch('/{sublocation}', [
        'as' => 'playground.directory.api.sublocations.patch',
        'uses' => 'SublocationController@update',
    ])->whereUuid('sublocation')->can('update', 'sublocation');
});
