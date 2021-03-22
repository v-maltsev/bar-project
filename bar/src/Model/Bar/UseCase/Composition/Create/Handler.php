<?php

declare(strict_types=1);

namespace App\Model\Bar\UseCase\Composition\Create;

use App\Model\Bar\Entity\Composition\Composition;
use App\Model\Bar\Entity\Composition\CompositionRepository;
use App\Model\Bar\Entity\Genre\GenreRepository;
use App\Model\Flusher;

class Handler
{
    private CompositionRepository $compositions;
    private GenreRepository $genres;
    private Flusher $flusher;

    public function __construct(CompositionRepository $compositions,GenreRepository $genres, Flusher $flusher)
    {
        $this->compositions = $compositions;
        $this->genres = $genres;
        $this->flusher = $flusher;
    }

    public function handle(Command $command):void
    {
        $composition = new Composition();
        $composition->setName($command->name);

        if (!$genre = $this->genres->get($command->genderId)) {
            throw new \DomainException('Genre didnt exist.');
        }

        $composition->setGenre($genre);

        $this->compositions->add($composition);

        $this->flusher->flush();
    }
}