<?php

declare(strict_types=1);

namespace App\Command\Visitor;

use App\Model\Bar\UseCase\Visitor\Create;
use App\Model\Bar\UseCase\Visitor\Create\Handler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreateVisitor extends Command
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
            ->setName('bar:visitor:create')
            ->setDescription('Create new visitor');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        $name = $helper->ask($input, $output, new Question('Name: '));

        $command = new Create\Command();
        $command->name = $name;

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