<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Directory\Api\Policies\ContactPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Directory\Api\Policies\ContactPolicy;
use Tests\Unit\Playground\Directory\Api\TestCase;

/**
 * \Tests\Unit\Playground\Directory\Api\Policies\ContactPolicy\PolicyTest
 */
#[CoversClass(ContactPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new ContactPolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(ContactPolicy::class, $instance);
    }
}
