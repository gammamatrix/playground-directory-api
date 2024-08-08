<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Directory\Api\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\Playground\Directory\Api\TestCase as BaseTestCase;

/**
 * \Tests\Feature\Playground\Directory\Api\Http\Controllers\TestCase
 */
class TestCase extends BaseTestCase
{
    use Resource\Playground\CreateJsonTrait;
    use Resource\Playground\DestroyJsonTrait;
    use Resource\Playground\EditJsonTrait;
    use Resource\Playground\IndexJsonTrait;
    use Resource\Playground\LockJsonTrait;
    use Resource\Playground\RestoreJsonTrait;
    use Resource\Playground\RestoreRevisionJsonTrait;
    use Resource\Playground\RevisionJsonTrait;
    use Resource\Playground\RevisionsJsonTrait;
    use Resource\Playground\ShowJsonTrait;
    use Resource\Playground\StoreJsonTrait;
    use Resource\Playground\UnlockJsonTrait;
    use Resource\Playground\UpdateJsonTrait;

    protected bool $setUpUserForPlayground = true;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => '',
        'model_label_plural' => '',
        'model_route' => '',
        'model_slug' => '',
        'model_slug_plural' => '',
        'module_label' => 'Directory',
        'module_label_plural' => 'Directories',
        'module_route' => 'playground.directory.api',
        'module_slug' => 'directory',
        'privilege' => 'playground-directory-api:',
        'table' => '',
        'view' => 'playground.directory.api::',
    ];

    /**
     * @var class-string<Model>
     */
    public string $fqdn = Model::class;

    /**
     * @var class-string<Model>
     */
    public string $fqdnRevision = Model::class;

    public string $revisionId = 'revision_id';

    public string $revisionRouteParameter = 'revision';

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
    ];

    /**
     * @return class-string<Model>
     */
    public function getGetFqdn(): string
    {
        return $this->fqdn;
    }

    /**
     * @return class-string<Model>
     */
    public function getGetFqdnRevision(): string
    {
        return $this->fqdnRevision;
    }

    public function getRevisionId(): string
    {
        return $this->revisionId;
    }

    public function getRevisionRouteParameter(): string
    {
        return $this->revisionRouteParameter;
    }

    /**
     * @return array<string, string>
     */
    public function getPackageInfo(): array
    {
        return $this->packageInfo;
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureCreate(): array
    {
        return [
            'data' => array_diff($this->structure_model, [
                'id',
            ]),
            'meta' => [
                'timestamp',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureData(): array
    {
        return [
            'data' => $this->structure_model,
            'meta' => [
                'timestamp',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureEdit(): array
    {
        return [
            'data' => $this->structure_model,
            'meta' => [
                'timestamp',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStructureIndex(): array
    {
        return [
            'data' => [
                '*' => $this->structure_model,
            ],
            'meta' => [
                'session_user_id',
                'sortable',
                'timestamp',
                'validated' => [
                    'perPage',
                    'page',
                ],
                // 'pagination' => [
                //     'count',
                //     'current_page',
                //     'links' => [
                //         'first',
                //         'last',
                //         'next',
                //         'path',
                //         'previous',
                //     ],
                //     'from',
                //     'last_page',
                //     'next_page',
                //     'per_page',
                //     'prev_page',
                //     'to',
                //     'total',
                //     'total_pages',
                // ],
            ],

        ];
    }
}
