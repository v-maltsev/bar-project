<?php

declare(strict_types=1);

namespace App\Model\Bar\UseCase\PlayList\Add;

use App\Model\Bar\Entity\Composition\CompositionRepository;
use App\Model\Bar\Entity\PlayList\PlayList;
use App\Model\Bar\Entity\PlayList\PlayListRepository;
use App\Model\Bar\UseCase\PlayList\Add\Command;
use App\Model\Flusher;

class Handler
{
    private PlayListRepository $playlistRepo;
    private CompositionRepository $compositions;
    private Flusher $flusher;

    public function __construct(PlayListRepository $playlistRepo, CompositionRepository $compositions, Flusher $flusher)
    {
        $this->playlistRepo = $playlistRepo;
        $this->compositions = $compositions;
        $this->flusher = $flusher;
    }

    public function handle(Command $command):void
    {
        if (!$composition = $this->compositions->get($command->compositionId)) {
            throw new \DomainException('Composition didnt exist.');
        }

        $playList = new playList();
        $playList->setComposition($composition);
        $this->playlistRepo->add($playList);

        $this->flusher->flush($playList);
    }
}