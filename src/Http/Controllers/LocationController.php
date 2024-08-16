<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Directory\Api\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Playground\Directory\Api\Http\Requests;
use Playground\Directory\Api\Http\Resources;
use Playground\Directory\Models\Location;
use Playground\Directory\Models\LocationRevision;

/**
 * \Playground\Directory\Api\Http\Controllers\LocationController
 */
class LocationController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Location',
        'model_label_plural' => 'Locations',
        'model_route' => 'playground.directory.api.locations',
        'model_slug' => 'location',
        'model_slug_plural' => 'locations',
        'module_label' => 'Directory',
        'module_label_plural' => 'Directories',
        'module_route' => 'playground.directory.api',
        'module_slug' => 'directory',
        'privilege' => 'playground-directory-api:location',
        'table' => 'directory_locations',
    ];

    /**
     * Create the Location resource in storage.
     *
     * @route GET /api/directory/locations/create playground.directory.api.locations.create
     */
    public function create(
        Requests\Location\CreateRequest $request
    ): JsonResponse|Resources\Location {

        $validated = $request->validated();

        $user = $request->user();

        $location = new Location($validated);

        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Location resource in storage.
     *
     * @route GET /api/directory/locations/edit/{location} playground.directory.api.locations.edit
     */
    public function edit(
        Location $location,
        Requests\Location\EditRequest $request
    ): JsonResponse|Resources\Location {
        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Location resource from storage.
     *
     * @route DELETE /api/directory/locations/{location} playground.directory.api.locations.destroy
     */
    public function destroy(
        Location $location,
        Requests\Location\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $location->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $location->delete();
        } else {
            $location->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Location resource in storage.
     *
     * @route PUT /api/directory/locations/{location} playground.directory.api.locations.lock
     */
    public function lock(
        Location $location,
        Requests\Location\LockRequest $request
    ): JsonResponse|Resources\Location {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $location->modified_by_id = $user->id;
        }

        $location->locked = true;

        $location->save();

        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Location resources.
     *
     * @route GET /api/directory/locations playground.directory.api.locations
     */
    public function index(
        Requests\Location\IndexRequest $request
    ): JsonResponse|Resources\LocationCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Location::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {

            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\LocationCollection($paginator))->response($request);
    }

    /**
     * Restore the Location resource from the trash.
     *
     * @route PUT /api/directory/locations/restore/{location} playground.directory.api.locations.restore
     */
    public function restore(
        Location $location,
        Requests\Location\RestoreRequest $request
    ): JsonResponse|Resources\Location {

        $user = $request->user();

        if ($user?->id) {
            $location->modified_by_id = $user->id;
        }

        $location->restore();

        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Location resource from the trash.
     *
     * @route PUT /api/directory/locations/revision/{location_revision} playground.directory.api.locations.revision.restore
     */
    public function restoreRevision(
        LocationRevision $location_revision,
        Requests\Location\RestoreRevisionRequest $request
    ): JsonResponse|Resources\Location {
        $validated = $request->validated();

        /**
         * @var Location $location
         */
        $location = Location::where(
            'id',
            $location_revision->location_id
        )->firstOrFail();

        $this->saveRevision($location);

        $user = $request->user();

        foreach ($location->getFillable() as $column) {
            $location->setAttribute(
                $column,
                $location_revision->getAttributeValue($column)
            );
        }

        $location->save();

        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Location revision.
     *
     * @route GET /api/directory/locations/revision/{location_revision} playground.directory.api.locations.revision
     */
    public function revision(
        LocationRevision $location_revision,
        Requests\Location\ShowRevisionRequest $request
    ): JsonResponse|Resources\LocationRevision {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $location_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new Resources\LocationRevision($location_revision))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Location resources.
     *
     * @route GET /api/directory/locations/{location}/revisions playground.directory.api.locations.revisions
     */
    public function revisions(
        Location $location,
        Requests\Location\RevisionsRequest $request
    ): JsonResponse|Resources\LocationRevisionCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = $location->revisions();

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {
            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        return (new Resources\LocationRevisionCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Save a revision of a Location.
     */
    public function saveRevision(Location $location): LocationRevision
    {
        $revision = new LocationRevision($location->toArray());

        $revision->created_by_id = $location->created_by_id;
        $revision->modified_by_id = $location->modified_by_id;
        $revision->owned_by_id = $location->owned_by_id;
        $revision->location_id = $location->id;

        $r = LocationRevision::where('location_id', $location->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->revision = $r;
        $location->revision = $r;

        $revision->saveOrFail();

        return $revision;
    }

    /**
     * Display the Location resource.
     *
     * @route GET /api/directory/locations/{location} playground.directory.api.locations.show
     */
    public function show(
        Location $location,
        Requests\Location\ShowRequest $request
    ): JsonResponse|Resources\Location {
        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Location resource in storage.
     *
     * @route POST /api/directory/locations playground.directory.api.locations.post
     */
    public function store(
        Requests\Location\StoreRequest $request
    ): Response|JsonResponse|Resources\Location {
        $validated = $request->validated();

        $user = $request->user();

        $location = new Location($validated);

        $location->created_by_id = $user?->id;

        $location->save();

        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Location resource in storage.
     *
     * @route DELETE /api/directory/locations/lock/{location} playground.directory.api.locations.unlock
     */
    public function unlock(
        Location $location,
        Requests\Location\UnlockRequest $request
    ): JsonResponse|Resources\Location {

        $validated = $request->validated();

        $user = $request->user();

        $location->locked = false;

        if ($user?->id) {
            $location->modified_by_id = $user->id;
        }

        $location->save();

        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Location resource in storage.
     *
     * @route PATCH /api/directory/locations/{location} playground.directory.api.locations.patch
     */
    public function update(
        Location $location,
        Requests\Location\UpdateRequest $request
    ): JsonResponse {

        $this->saveRevision($location);

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $location->modified_by_id = $user->id;
        }

        $location->update($validated);

        return (new Resources\Location($location))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
