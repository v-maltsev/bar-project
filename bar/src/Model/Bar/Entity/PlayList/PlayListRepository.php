<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\PlayList;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class PlayListRepository
{
    private EntityRepository $repo;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repo = $entityManager->getRepository(PlayList::class);
    }

    public function add(PlayList $playList): void
    {
        $this->entityManager->persist($playList);
    }

    public function getLast(): PlayList
    {
        /**
         * @var PlayList $playList
         */
        if (!$playList = $this->repo->findOneBy([],['id'=>'desc'])) {
            throw new \DomainException('playlist is not found.');
        }
        return $playList;
    }
}