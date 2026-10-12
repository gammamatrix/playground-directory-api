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
use Playground\Directory\Models\Contact;
use Playground\Directory\Models\ContactRevision;

/**
 * \Playground\Directory\Api\Http\Controllers\ContactController
 */
class ContactController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_camel' => 'contact',
        'model_camels' => 'contacts',
        'model_kebab' => 'contact',
        'model_kebabs' => 'contacts',
        'model_lower' => 'contact',
        'model_lowers' => 'contacts',
        'model_label' => 'Contact',
        'model_labels' => 'Contacts',
        'model_label_plural' => 'Contacts',
        'model_route' => 'playground.directory.api.contacts',
        'model_route_param' => 'contact',
        'model_slug' => 'contact',
        'model_slugs' => 'contacts',
        'model_slug_plural' => 'contacts',
        'model_snake' => 'contact',
        'model_snakes' => 'contacts',
        'model_studly' => 'Contact',
        'model_studlies' => 'Contacts',
        'model_variable' => 'contact',
        'model_variables' => 'contacts',
        'model_variable_plural' => 'contacts',
        'module_label' => 'Directory',
        'module_labels' => 'Directories',
        'module_label_plural' => 'Directories',
        'module_route' => 'playground.directory.api',
        'module_slug' => 'directory',
        'module_slugs' => 'directories',
        'privilege' => 'playground-directory-api:contact',
        'table' => 'directory_contacts',
    ];

    /**
     * Create the Contact resource in storage.
     *
     * @route GET /api/directory/contacts/create playground.directory.api.contacts.create
     */
    public function create(
        Requests\Contact\CreateRequest $request
    ): JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $contact = new Contact($validated);

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Edit the Contact resource in storage.
     *
     * @route GET /api/directory/contacts/edit/{contact} playground.directory.api.contacts.edit
     */
    public function edit(
        Contact $contact,
        Requests\Contact\EditRequest $request
    ): JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Remove the Contact resource from storage.
     *
     * @route DELETE /api/directory/contacts/{contact} playground.directory.api.contacts.destroy
     */
    public function destroy(
        Contact $contact,
        Requests\Contact\DestroyRequest $request
    ): Response {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $contact->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $contact->delete();
        } else {
            $contact->forceDelete();
        }

        return response()->noContent();
    }

    /**
     * Lock the Contact resource in storage.
     *
     * @route PUT /api/directory/contacts/{contact} playground.directory.api.contacts.lock
     */
    public function lock(
        Contact $contact,
        Requests\Contact\LockRequest $request
    ): JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        if ($user?->id) {
            $contact->modified_by_id = $user->id;
        }

        $contact->locked = true;

        $contact->save();

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Contact resources.
     *
     * @route GET /api/directory/contacts playground.directory.api.contacts
     */
    public function index(
        Requests\Contact\IndexRequest $request
    ): JsonResponse|Resources\ContactCollection {

        $packageInfo = $this->packageInfo();

        /**
         * @var array{
         *     sort: string|array<mixed>,
         *     filter: array{
         *         trash: string
         *     },
         *     perPage: int
         * } $validated
         */
        $validated = $request->validated();

        $query = Contact::addSelect(sprintf('%1$s.*', $packageInfo->table()));

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

        return new Resources\ContactCollection($paginator)->response($request);
    }

    /**
     * Restore the Contact resource from the trash.
     *
     * @route PUT /api/directory/contacts/restore/{contact} playground.directory.api.contacts.restore
     */
    public function restore(
        Contact $contact,
        Requests\Contact\RestoreRequest $request
    ): JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $contact->modified_by_id = $user?->id;

        $contact->restore();

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Restore the Contact resource from the trash.
     *
     * @route PUT /api/directory/contacts/revision/{contact_revision} playground.directory.api.contacts.revision.restore
     */
    public function restoreRevision(
        ContactRevision $contact_revision,
        Requests\Contact\RestoreRevisionRequest $request
    ): JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        /**
         * @var Contact $contact
         */
        $contact = Contact::where(
            'id',
            $contact_revision->contact_id
        )->firstOrFail();

        $this->saveRevision($contact);

        $user = $request->user();

        foreach ($contact->getFillable() as $column) {
            $contact->setAttribute(
                $column,
                $contact_revision->getAttributeValue($column)
            );
        }

        $contact->save();

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display the Contact revision.
     *
     * @route GET /api/directory/contacts/revision/{contact_revision} playground.directory.api.contacts.revision
     */
    public function revision(
        ContactRevision $contact_revision,
        Requests\Contact\ShowRevisionRequest $request
    ): JsonResponse|Resources\ContactRevision {

        $packageInfo = $this->packageInfo();

        return new Resources\ContactRevision($contact_revision)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Display a listing of Contact resources.
     *
     * @route GET /api/directory/contacts/{contact}/revisions playground.directory.api.contacts.revisions
     */
    public function revisions(
        Contact $contact,
        Requests\Contact\RevisionsRequest $request
    ): JsonResponse|Resources\ContactRevisionCollection {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        /**
         * @var array{
         *     sort: string|array<mixed>,
         *     filter: array{
         *         trash: string
         *     },
         *     perPage: int
         * } $validated
         */
        $validated = $request->validated();

        $query = $contact->revisions();

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

        return new Resources\ContactRevisionCollection($paginator)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Save a revision of a Contact.
     */
    public function saveRevision(Contact $contact): ContactRevision
    {
        /**
         * @var array<string, mixed> $data
         */
        $data = $contact->toArray();

        $revision = new ContactRevision($data);

        $revision->created_by_id = $contact->created_by_id;
        $revision->modified_by_id = $contact->modified_by_id;
        $revision->owned_by_id = $contact->owned_by_id;
        $revision->contact_id = $contact->id;

        $r = ContactRevision::where('contact_id', $contact->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->revision = $r;
        $contact->revision = $r;

        $revision->saveOrFail();

        return $revision;
    }

    /**
     * Display the Contact resource.
     *
     * @route GET /api/directory/contacts/{contact} playground.directory.api.contacts.show
     */
    public function show(
        Contact $contact,
        Requests\Contact\ShowRequest $request
    ): JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Store a newly created API Contact resource in storage.
     *
     * @route POST /api/directory/contacts playground.directory.api.contacts.post
     */
    public function store(
        Requests\Contact\StoreRequest $request
    ): Response|JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        $validated = $request->validated();

        $user = $request->user();

        $contact = new Contact($validated);

        $contact->created_by_id = $user?->id;

        $contact->save();

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request)->setStatusCode(201);
    }

    /**
     * Unlock the Contact resource in storage.
     *
     * @route DELETE /api/directory/contacts/lock/{contact} playground.directory.api.contacts.unlock
     */
    public function unlock(
        Contact $contact,
        Requests\Contact\UnlockRequest $request
    ): JsonResponse|Resources\Contact {

        $packageInfo = $this->packageInfo();

        $user = $request->user();

        $contact->locked = false;

        $contact->modified_by_id = $user?->id;

        $contact->save();

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }

    /**
     * Update the Contact resource in storage.
     *
     * @route PATCH /api/directory/contacts/{contact} playground.directory.api.contacts.patch
     */
    public function update(
        Contact $contact,
        Requests\Contact\UpdateRequest $request
    ): JsonResponse {

        $packageInfo = $this->packageInfo();

        $this->saveRevision($contact);

        $validated = $request->validated();

        $user = $request->user();

        $contact->modified_by_id = $user?->id;

        $contact->update($validated);

        return new Resources\Contact($contact)->additional(['meta' => [
            'info' => $packageInfo,
        ]])->response($request);
    }
}
