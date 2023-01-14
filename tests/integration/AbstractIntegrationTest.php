<?php

declare(strict_types=1);

namespace App\Tests\integration;

use App\Shared\Infrastructure\Persistence\Filesystem\SleekStorage;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @author Adam Banaszkiewicz
 */
abstract class AbstractIntegrationTest extends KernelTestCase
{
    protected function setUp(): void
    {
        $this->get(SleekStorage::class)->clear();
    }

    public function get(string $service): object
    {
        return self::getContainer()->get($service);
    }
}
