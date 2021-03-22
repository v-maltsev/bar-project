<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\Composition;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CompositionRepository
{
    private EntityRepository $repo;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $entityManager->getRepository(Composition::class);
    }

    public function get(int $id): Composition
    {
        /**
         * @var Composition $composition
         */
        if (!$composition = $this->repo->find($id)) {
            throw new \DomainException('Composition is not found.');
        }
        return $composition;
    }

    /**
     * @return Composition[]
     */
    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function add(Composition $composition): void
    {
        $this->entityManager->persist($composition);
    }

    public function remove(Composition $composition): void
    {
        $this->entityManager->remove($composition);
    }
}