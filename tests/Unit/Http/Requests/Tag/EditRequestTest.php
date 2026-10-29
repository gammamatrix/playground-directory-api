<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Directory\Api\Http\Requests\Tag;

use Playground\Directory\Api\Http\Requests\Tag\EditRequest;
use Tests\Unit\Playground\Directory\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Directory\Api\Http\Requests\Tag\EditRequestTest
 */
class EditRequestTest extends RequestTestCase
{
    protected string $requestClass = EditRequest::class;
}
