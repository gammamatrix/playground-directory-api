<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Directory\Api\Http\Requests\Tagged;

use Playground\Directory\Api\Http\Requests\Tagged\StoreRequest;
use Tests\Unit\Playground\Directory\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Directory\Api\Http\Requests\Tagged\StoreRequestTest
 */
class StoreRequestTest extends RequestTestCase
{
    protected string $requestClass = StoreRequest::class;
}
