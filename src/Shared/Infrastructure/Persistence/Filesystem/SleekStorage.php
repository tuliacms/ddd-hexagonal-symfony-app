<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\Filesystem;

use SleekDB\Exceptions\InvalidArgumentException;
use SleekDB\Exceptions\InvalidConfigurationException;
use SleekDB\Exceptions\IOException;
use SleekDB\Store;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Adam Banaszkiewicz
 */
final class SleekStorage
{
    /** @var Store[] */
    private array $stores = [];

    public function __construct(
        private readonly string $varDirectory,
        private readonly string $environment,
    ) {
    }

    public function clear(): void
    {
        (new Filesystem())->remove($this->directory());
    }

    /**
     * @throws InvalidConfigurationException
     * @throws InvalidArgumentException
     * @throws IOException
     */
    public function store(string $name): Store
    {
        if (!isset($this->stores[$name])) {
            $this->stores[$name] = new Store(
                $name,
                $this->directory(),
                [
                    'timeout' => false,
                ]
            );
        }

        return $this->stores[$name];
    }

    private function directory(): string
    {
        return sprintf('%s/%s.%s', $this->varDirectory, 'sleek-storage', $this->environment);
    }
}
