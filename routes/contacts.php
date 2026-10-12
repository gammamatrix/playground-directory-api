<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Directory\Models\Contact;

/*
|--------------------------------------------------------------------------
| Directory API Routes: Contact
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/directory/contact',
    'middleware' => config('playground-directory-api.middleware.default'),
    'namespace' => '\Playground\Directory\Api\Http\Controllers',
], function () {

    Route::get('/{contact:slug}', [
        'as' => 'playground.directory.api.contacts.slug',
        'uses' => 'ContactController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/directory/contacts',
    'middleware' => config('playground-directory-api.middleware.default'),
    'namespace' => '\Playground\Directory\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.directory.api.contacts',
        'uses' => 'ContactController@index',
    ])->can('index', Contact::class);

    Route::post('/index', [
        'as' => 'playground.directory.api.contacts.index',
        'uses' => 'ContactController@index',
    ])->can('index', Contact::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.directory.api.contacts.create',
        'uses' => 'ContactController@create',
    ])->can('create', Contact::class);

    Route::get('/edit/{contact}', [
        'as' => 'playground.directory.api.contacts.edit',
        'uses' => 'ContactController@edit',
    ])->whereUuid('contact')->can('edit', 'contact');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.directory.api.contacts.go',
    //     'uses' => 'ContactController@go',
    // ]);

    Route::get('/{contact}', [
        'as' => 'playground.directory.api.contacts.show',
        'uses' => 'ContactController@show',
    ])->whereUuid('contact')->can('detail', 'contact')->withTrashed();

    Route::get('/{contact}/revisions', [
        'as' => 'playground.directory.api.contacts.revisions',
        'uses' => 'ContactController@revisions',
    ])->whereUuid('contact')->can('revisions', 'contact');

    Route::post('/{contact}/revisions', [
        'uses' => 'ContactController@revisions',
    ])->whereUuid('contact')->can('revisions', 'contact');

    Route::get('/revision/{contact_revision}', [
        'as' => 'playground.directory.api.contacts.revision',
        'uses' => 'ContactController@revision',
    ])->whereUuid('contact')->can('viewRevision', 'contact_revision');

    Route::put('/revision/{contact_revision}', [
        'as' => 'playground.directory.api.contacts.revision.restore',
        'uses' => 'ContactController@restoreRevision',
    ])->whereUuid('contact_revision')->can('restoreRevision', 'contact_revision');

    // API

    Route::put('/lock/{contact}', [
        'as' => 'playground.directory.api.contacts.lock',
        'uses' => 'ContactController@lock',
    ])->whereUuid('contact')->can('lock', 'contact');

    Route::delete('/lock/{contact}', [
        'as' => 'playground.directory.api.contacts.unlock',
        'uses' => 'ContactController@unlock',
    ])->whereUuid('contact')->can('unlock', 'contact');

    Route::delete('/{contact}', [
        'as' => 'playground.directory.api.contacts.destroy',
        'uses' => 'ContactController@destroy',
    ])->whereUuid('contact')->can('delete', 'contact')->withTrashed();

    Route::put('/restore/{contact}', [
        'as' => 'playground.directory.api.contacts.restore',
        'uses' => 'ContactController@restore',
    ])->whereUuid('contact')->can('restore', 'contact')->withTrashed();

    Route::post('/', [
        'as' => 'playground.directory.api.contacts.post',
        'uses' => 'ContactController@store',
    ])->can('store', Contact::class);

    // Route::put('/', [
    //     'as' => 'playground.directory.api.contacts.put',
    //     'uses' => 'ContactController@store',
    // ])->can('store', Playground\Directory\Models\Contact::class);
    //
    // Route::put('/{contact}', [
    //     'as' => 'playground.directory.api.contacts.put.id',
    //     'uses' => 'ContactController@store',
    // ])->whereUuid('contact')->can('update', 'contact');

    Route::patch('/{contact}', [
        'as' => 'playground.directory.api.contacts.patch',
        'uses' => 'ContactController@update',
    ])->whereUuid('contact')->can('update', 'contact');
});
