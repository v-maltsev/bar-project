<?php

declare(strict_types=1);

namespace App\Model\Bar\UseCase\Visitor\Create;

use App\Model\Bar\Entity\Visitor\Visitor;
use App\Model\Bar\Entity\Visitor\VisitorRepository;
use App\Model\Flusher;

class Handler
{
    private VisitorRepository $visitors;
    private Flusher $flusher;

    public function __construct(VisitorRepository $visitors, Flusher $flusher)
    {
        $this->visitors = $visitors;
        $this->flusher = $flusher;
    }

    public function handle(Command $command):void
    {
        $visitor = new Visitor();
        $visitor->setName($command->name);

        $this->visitors->add($visitor);

        $this->flusher->flush();
    }
}