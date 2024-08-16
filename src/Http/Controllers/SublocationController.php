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
use Playground\Directory\Models\Sublocation;
use Playground\Directory\Models\SublocationRevision;

/**
 * \Playground\Directory\Api\Http\Controllers\SublocationController
 */
class SublocationController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Sublocation',
        'model_label_plural' => 'Sublocations',
        'model_route' => 'playground.directory.api.sublocations',
        'model_slug' => 'sublocation',
        'model_slug_plural' => 'sublocations',
        'module_label' => 'Directory',
        'module_label_plural' => 'Directories',
        'module_route' => 'playground.directory.api',
        'module_slug' => 'directory',
        'privilege' => 'playground-directory-api:sublocation',
        'table' => 'directory_sublocations',
    ];

    /**
     * Create the Sublocation resource in storage.
     *
     * @route GET /api/directory/sublocations/create playground.directory.api.sublocations.create
     */
    public function create(
        Requests\Sublocation\CreateRequest $request
    ): JsonResponse|Resources\Sublocation {

        $validated = $request->validated();

        $user = $request->user();

        $sublocation = new Sublocation($validated);

        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Sublocation resource in storage.
     *
     * @route GET /api/directory/sublocations/edit/{sublocation} playground.directory.api.sublocations.edit
     */
    public function edit(
        Sublocation $sublocation,
        Requests\Sublocation\EditRequest $request
    ): JsonResponse|Resources\Sublocation {
        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Sublocation resource from storage.
     *
     * @route DELETE /api/directory/sublocations/{sublocation} playground.directory.api.sublocations.destroy
     */
    public function destroy(
        Sublocation $sublocation,
        Requests\Sublocation\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $sublocation->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $sublocation->delete();
        } else {
            $sublocation->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Sublocation resource in storage.
     *
     * @route PUT /api/directory/sublocations/{sublocation} playground.directory.api.sublocations.lock
     */
    public function lock(
        Sublocation $sublocation,
        Requests\Sublocation\LockRequest $request
    ): JsonResponse|Resources\Sublocation {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $sublocation->modified_by_id = $user->id;
        }

        $sublocation->locked = true;

        $sublocation->save();

        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Sublocation resources.
     *
     * @route GET /api/directory/sublocations playground.directory.api.sublocations
     */
    public function index(
        Requests\Sublocation\IndexRequest $request
    ): JsonResponse|Resources\SublocationCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Sublocation::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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

        return (new Resources\SublocationCollection($paginator))->response($request);
    }

    /**
     * Restore the Sublocation resource from the trash.
     *
     * @route PUT /api/directory/sublocations/restore/{sublocation} playground.directory.api.sublocations.restore
     */
    public function restore(
        Sublocation $sublocation,
        Requests\Sublocation\RestoreRequest $request
    ): JsonResponse|Resources\Sublocation {

        $user = $request->user();

        if ($user?->id) {
            $sublocation->modified_by_id = $user->id;
        }

        $sublocation->restore();

        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Sublocation resource from the trash.
     *
     * @route PUT /api/directory/sublocations/revision/{sublocation_revision} playground.directory.api.sublocations.revision.restore
     */
    public function restoreRevision(
        SublocationRevision $sublocation_revision,
        Requests\Sublocation\RestoreRevisionRequest $request
    ): JsonResponse|Resources\Sublocation {
        $validated = $request->validated();

        /**
         * @var Sublocation $sublocation
         */
        $sublocation = Sublocation::where(
            'id',
            $sublocation_revision->sublocation_id
        )->firstOrFail();

        $this->saveRevision($sublocation);

        $user = $request->user();

        foreach ($sublocation->getFillable() as $column) {
            $sublocation->setAttribute(
                $column,
                $sublocation_revision->getAttributeValue($column)
            );
        }

        $sublocation->save();

        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Sublocation revision.
     *
     * @route GET /api/directory/sublocations/revision/{sublocation_revision} playground.directory.api.sublocations.revision
     */
    public function revision(
        SublocationRevision $sublocation_revision,
        Requests\Sublocation\ShowRevisionRequest $request
    ): JsonResponse|Resources\SublocationRevision {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $sublocation_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        return (new Resources\SublocationRevision($sublocation_revision))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Sublocation resources.
     *
     * @route GET /api/directory/sublocations/{sublocation}/revisions playground.directory.api.sublocations.revisions
     */
    public function revisions(
        Sublocation $sublocation,
        Requests\Sublocation\RevisionsRequest $request
    ): JsonResponse|Resources\SublocationRevisionCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = $sublocation->revisions();

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

        return (new Resources\SublocationRevisionCollection($paginator))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Save a revision of a Sublocation.
     */
    public function saveRevision(Sublocation $sublocation): SublocationRevision
    {
        $revision = new SublocationRevision($sublocation->toArray());

        $revision->created_by_id = $sublocation->created_by_id;
        $revision->modified_by_id = $sublocation->modified_by_id;
        $revision->owned_by_id = $sublocation->owned_by_id;
        $revision->sublocation_id = $sublocation->id;

        $r = SublocationRevision::where('sublocation_id', $sublocation->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->revision = $r;
        $sublocation->revision = $r;

        $revision->saveOrFail();

        return $revision;
    }

    /**
     * Display the Sublocation resource.
     *
     * @route GET /api/directory/sublocations/{sublocation} playground.directory.api.sublocations.show
     */
    public function show(
        Sublocation $sublocation,
        Requests\Sublocation\ShowRequest $request
    ): JsonResponse|Resources\Sublocation {
        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Sublocation resource in storage.
     *
     * @route POST /api/directory/sublocations playground.directory.api.sublocations.post
     */
    public function store(
        Requests\Sublocation\StoreRequest $request
    ): Response|JsonResponse|Resources\Sublocation {
        $validated = $request->validated();

        $user = $request->user();

        $sublocation = new Sublocation($validated);

        $sublocation->created_by_id = $user?->id;

        $sublocation->save();

        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Sublocation resource in storage.
     *
     * @route DELETE /api/directory/sublocations/lock/{sublocation} playground.directory.api.sublocations.unlock
     */
    public function unlock(
        Sublocation $sublocation,
        Requests\Sublocation\UnlockRequest $request
    ): JsonResponse|Resources\Sublocation {

        $validated = $request->validated();

        $user = $request->user();

        $sublocation->locked = false;

        if ($user?->id) {
            $sublocation->modified_by_id = $user->id;
        }

        $sublocation->save();

        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Sublocation resource in storage.
     *
     * @route PATCH /api/directory/sublocations/{sublocation} playground.directory.api.sublocations.patch
     */
    public function update(
        Sublocation $sublocation,
        Requests\Sublocation\UpdateRequest $request
    ): JsonResponse {

        $this->saveRevision($sublocation);

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $sublocation->modified_by_id = $user->id;
        }

        $sublocation->update($validated);

        return (new Resources\Sublocation($sublocation))->additional(['meta' => [
            'info' => $this->packageInfo,
        ]])->response($request);
    }
}
