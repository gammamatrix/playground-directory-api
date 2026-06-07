<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Directory\Api\Console\Commands\About;

use Illuminate\Testing\PendingCommand;
use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Directory\Api\ServiceProvider;
use Symfony\Component\Console\Command\Command;
use Tests\Feature\Playground\Directory\Api\TestCase;

/**
 * \Tests\Feature\Playground\Directory\Api\Console\Commands\About\CommandTest
 */
#[CoversClass(ServiceProvider::class)]
class CommandTest extends TestCase
{
    public function test_command_about_displays_package_information_and_succeed(): void
    {
        /**
         * @var PendingCommand $result
         */
        $result = $this->artisan('about');
        $result->assertExitCode(Command::SUCCESS);
        $result->expectsOutputToContain('Playground: Directory API');
    }
}
