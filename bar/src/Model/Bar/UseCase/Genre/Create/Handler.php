<?php

declare(strict_types=1);

namespace App\Model\Bar\UseCase\Genre\Create;

use App\Model\Bar\Entity\Genre\Genre;
use App\Model\Bar\Entity\Genre\GenreRepository;
use App\Model\Flusher;

class Handler
{
    private GenreRepository $genres;
    private Flusher $flusher;

    public function __construct(GenreRepository $genres, Flusher $flusher)
    {
        $this->genres = $genres;
        $this->flusher = $flusher;
    }

    public function handle(Command $command):void
    {
        $genre = new Genre();
        $genre->setName($command->name);

        $this->genres->add($genre);

        $this->flusher->flush();
    }
}