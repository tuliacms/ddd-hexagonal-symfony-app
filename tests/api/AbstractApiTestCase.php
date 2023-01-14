<?php

declare(strict_types=1);

namespace App\Tests\api;

use App\Shared\Infrastructure\Persistence\Filesystem\SleekStorage;
use Helmich\JsonAssert\JsonAssertions;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Adam Banaszkiewicz
 */
abstract class AbstractApiTestCase extends WebTestCase
{
    use JsonAssertions;

    private static KernelBrowser $client;

    protected function setUp(): void
    {
        $this->get(SleekStorage::class)->clear();
    }

    public function get(string $service): object
    {
        return self::getContainer()->get($service);
    }

    public function request(string $method, string $url, array $content = []): Response
    {
        self::$client = $this->getClient();
        self::$client->request(
            $method,
            $url,
            [],
            [],
            [],
            $content === [] ? null : json_encode($content, JSON_THROW_ON_ERROR)
        );

        return self::$client->getResponse();
    }

    protected static function getResponseContent(): array
    {
        return json_decode(self::$client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    public function getClient(): KernelBrowser
    {
        self::ensureKernelShutdown();

        return self::createClient([], [
            'HTTP_CONTENT_TYPE' => 'application/json',
        ]);
    }

    public static function assertResponseHasIdField(): void
    {
        self::assertArrayHasKey('id', self::getResponseContent());
    }
}
