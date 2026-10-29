<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Directory\Api\Http\Requests\Tagged;

use Playground\Directory\Api\Http\Requests\Tagged\DestroyRequest;
use Tests\Unit\Playground\Directory\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Directory\Api\Http\Requests\Tagged\DestroyRequestTest
 */
class DestroyRequestTest extends RequestTestCase
{
    protected string $requestClass = DestroyRequest::class;
}
