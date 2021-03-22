<?php

declare(strict_types=1);

namespace App\Command\Composition;

use App\Model\Bar\UseCase\Composition\Create;
use App\Model\Bar\UseCase\Composition\Create\Handler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateComposition extends Command
{
    private ValidatorInterface $validator;
    private Handler $handler;

    public function __construct(ValidatorInterface $validator, Handler $handler)
    {
        $this->validator = $validator;
        $this->handler = $handler;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('bar:composition:create')
            ->setDescription('Create new composition');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $name = $helper->ask($input, $output, new Question('Name: '));

        $genreId = $helper->ask($input, $output, new Question('Genre id: '));

        $command = new Create\Command();
        $command->name = $name;
        $command->genderId = (int) $genreId;

        $violations = $this->validator->validate($command);

        if ($violations->count()) {
            foreach ($violations as $violation) {
                $output->writeln('<error>' . $violation->getPropertyPath() . ': ' . $violation->getMessage() . '</error>');
            }
            return self::FAILURE;
        }

        $this->handler->handle($command);

        $output->writeln('<info>Done</info>');

        return self::SUCCESS;
    }
}