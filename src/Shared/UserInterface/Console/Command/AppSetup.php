<?php

declare(strict_types=1);

namespace App\Shared\UserInterface\Console\Command;

use App\Shared\Infrastructure\App\Setup\AppSetupperInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * @author Adam Banaszkiewicz
 */
#[AsCommand(name: 'app:setup')]
final class AppSetup extends Command
{
    /**
     * @param AppSetupperInterface[]|iterable $setuppers
     */
    public function __construct(
        #[TaggedIterator('app.setupper')]
        private readonly iterable $setuppers,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->setuppers as $setupper) {
            $setupper->setup();
        }

        $output->writeln('Application has been setupped successfully.');

        return Command::SUCCESS;
    }
}
