<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Directory\Api\Http\Requests\Tag;

use Playground\Directory\Api\Http\Requests\Tag\DestroyRequest;
use Tests\Unit\Playground\Directory\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Directory\Api\Http\Requests\Tag\DestroyRequestTest
 */
class DestroyRequestTest extends RequestTestCase
{
    protected string $requestClass = DestroyRequest::class;
}
