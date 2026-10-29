<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Directory\Api\Policies\TaggedPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Directory\Api\Policies\TaggedPolicy;
use Tests\Unit\Playground\Directory\Api\TestCase;

/**
 * \Tests\Unit\Playground\Directory\Api\Policies\TaggedPolicy\PolicyTest
 */
#[CoversClass(TaggedPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new TaggedPolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(TaggedPolicy::class, $instance);
    }
}
