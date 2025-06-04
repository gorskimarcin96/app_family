<?php

namespace App\Identity\UI\Console\Command;

use App\Identity\Application\Command\CreateUserCommand as CreateUserDto;
use App\Identity\Application\Handler\CreateUserHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:user:create', description: 'Creates a new user')]
final class CreateUserCommand extends Command
{
    public function __construct(
        private readonly CreateUserHandler $handler,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
            ->addArgument('password', InputArgument::REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->handler->__invoke(
            new CreateUserDto(
                email: $input->getArgument('email'),
                plainPassword: $input->getArgument('password'),
            ),
        );

        $io->success("User {$input->getArgument('email')} created.");

        return Command::SUCCESS;
    }
}
