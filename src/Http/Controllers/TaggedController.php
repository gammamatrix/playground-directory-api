<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Directory\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Playground\Directory\Api\Http\Requests;
use Playground\Directory\Api\Http\Resources;
use Playground\Directory\Models\Tagged;

/**
 * \Playground\Directory\Api\Http\Controllers\TaggedController
 */
class TaggedController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'tag_id',
        'model_camel' => 'tagged',
        'model_camels' => 'tagged',
        'model_kebab' => 'tagged',
        'model_kebabs' => 'tagged',
        'model_lower' => 'tagged',
        'model_lowers' => 'tagged',
        'model_label' => 'Tagged',
        'model_labels' => 'Tagged',
        'model_label_plural' => 'Tagged',
        'model_route' => 'playground.directory.api.tagged',
        'model_route_param' => 'tagged',
        'model_slug' => 'tagged',
        'model_slugs' => 'tagged',
        'model_slug_plural' => 'tagged',
        'model_snake' => 'tagged',
        'model_snakes' => 'tagged',
        'model_studly' => 'Tagged',
        'model_studlies' => 'Tagged',
        'model_variable' => 'tagged',
        'model_variables' => 'tagged',
        'model_variable_plural' => 'tagged',
        'module_label' => 'Directory',
        'module_labels' => 'Directories',
        'module_label_plural' => 'Directories',
        'module_route' => 'playground.directory.api',
        'module_slug' => 'directory',
        'module_slugs' => 'directories',
        'privilege' => 'playground-directory-api',
        'table' => 'directory_tagged',
    ];

    /**
     * Remove the Tagged resource from storage.
     *
     * @route DELETE /api/directory/tagged/{tagged} playground.directory.api.tagged.destroy
     */
    public function destroy(
        Tagged $tagged,
        Requests\Tagged\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $tagged->delete();

        return response()->noContent();
    }

    /**
     * Store a newly created API Tagged resource in storage.
     *
     * @route POST /api/directory/tagged playground.directory.api.tagged.post
     */
    public function store(
        Requests\Tagged\StoreRequest $request
    ): Response|JsonResponse|Resources\Tagged {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $tagged = new Tagged($validated);

        $tagged->created_by_id = $user?->id;

        $tagged->save();

        return new Resources\Tagged($tagged)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }
}
