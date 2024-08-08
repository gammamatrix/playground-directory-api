<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Directory\Api\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

/**
 * \Tests\Feature\Playground\Directory\Api\Http\Controllers\LocationTestCase
 */
class LocationTestCase extends TestCase
{
    public string $fqdn = \Playground\Directory\Models\Location::class;

    /**
     * @var class-string<Model>
     */
    public string $fqdnRevision = \Playground\Directory\Models\LocationRevision::class;

    public string $revisionId = 'location_id';

    public string $revisionRouteParameter = 'location_revision';

    protected int $status_code_json_guest_create = 401;

    protected int $status_code_json_guest_destroy = 401;

    protected int $status_code_json_guest_edit = 401;

    protected int $status_code_json_guest_index = 401;

    protected int $status_code_json_guest_lock = 401;

    protected int $status_code_json_guest_restore = 401;

    protected int $status_code_json_guest_restore_revision = 401;

    protected int $status_code_guest_json_revision = 401;

    protected int $status_code_guest_json_revisions = 401;

    protected int $status_code_json_guest_show = 401;

    protected int $status_code_guest_json_store = 401;

    protected int $status_code_guest_json_unlock = 401;

    protected int $status_code_guest_json_update = 401;

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
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'location_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'matrix_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'fixed_at',
        'planned_end_at',
        'planned_start_at',
        'postponed_at',
        'published_at',
        'released_at',
        'resumed_at',
        'resolved_at',
        'suspended_at',
        'timer_end_at',
        'timer_start_at',
        'gids',
        'po',
        'pg',
        'pw',
        'only_admin',
        'only_user',
        'only_guest',
        'allow_public',
        'status',
        'rank',
        'size',
        'revision',
        'matrix',
        'x',
        'y',
        'z',
        'r',
        'theta',
        'rho',
        'phi',
        'elevation',
        'latitude',
        'longitude',
        'active',
        'canceled',
        'closed',
        'completed',
        'cron',
        'duplicate',
        'fixed',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'prioritized',
        'problem',
        'published',
        'released',
        'resolved',
        'retired',
        'sitemap',
        'suspended',
        'unknown',
        'locale',
        'label',
        'title',
        'byline',
        'slug',
        'url',
        'description',
        'introduction',
        'content',
        'summary',
        'icon',
        'image',
        'avatar',
        'ui',
        'address',
        'assets',
        'contact',
        'meta',
        'notes',
        'options',
        'sources',
    ];
}
