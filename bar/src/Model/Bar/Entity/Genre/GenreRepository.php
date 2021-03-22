<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\Genre;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class GenreRepository
{
    private EntityRepository $repo;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $entityManager->getRepository(Genre::class);
    }

    public function add(Genre $genre): void
    {
        $this->entityManager->persist($genre);
    }

    public function get(int $id): Genre
    {
        /**
         * @var Genre $genre
         */
        if (!$genre = $this->repo->find($id)) {
            throw new \DomainException('Genre is not found.');
        }
        return $genre;
    }

    /**
     * @return Genre[]
     */
    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function remove(Genre $genre): void
    {
        $this->entityManager->remove($genre);
    }
}