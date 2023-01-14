<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\App\Setup;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * @author Adam Banaszkiewicz
 */
#[AutoconfigureTag('app.setupper')]
interface AppSetupperInterface
{
    public function setup(): void;
}
