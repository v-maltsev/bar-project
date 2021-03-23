<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\Visitor;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class VisitorRepository
{
    private EntityRepository $repo;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $entityManager->getRepository(Visitor::class);
    }

    public function get(int $id): Visitor
    {
        /**
         * @var Visitor $visitor
         */
        if (!$visitor = $this->repo->find($id)) {
            throw new \DomainException('Visitor is not found.');
        }
        return $visitor;
    }

    /**
     * @return Visitor[]
     */
    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    /**
     * @param int $status
     * @return Visitor[]|null
     */
    public function findAllByStatus(int $status): ?array
    {
        return $this->repo->findBy(['status' => $status]);
    }


    public function add(Visitor $visitor): void
    {
        $this->entityManager->persist($visitor);
    }

    public function remove(Visitor $visitor): void
    {
        $this->entityManager->remove($visitor);
    }
}