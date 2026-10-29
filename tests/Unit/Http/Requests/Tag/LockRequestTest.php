<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Directory\Api\Http\Requests\Tag;

use Playground\Directory\Api\Http\Requests\Tag\LockRequest;
use Tests\Unit\Playground\Directory\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Directory\Api\Http\Requests\Tag\LockRequestTest
 */
class LockRequestTest extends RequestTestCase
{
    protected string $requestClass = LockRequest::class;
}
