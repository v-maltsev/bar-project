<?php

declare(strict_types=1);

namespace App\Event\Listener\Bar\Playlist;

use App\Model\Bar\Entity\PlayList\Event\AddToPlayList;
use App\Model\Bar\Entity\Visitor\Visitor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddToPlaylistSubscriber implements EventSubscriberInterface
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
       return [
           AddToPlayList::class => [
               ['moveToDrink'],
               ['moveToDance'],
           ]
       ];
    }

    public function moveToDrink(AddToPlayList $event): void
    {
        $genre = $event->composition->getGenre();

        $this->entityManager->createQuery(
            'update App\Model\Bar\Entity\Visitor\Visitor v set v.status = :visitorStatus
            where :genreId NOT MEMBER OF v.genres'
            )
            ->setParameter('visitorStatus', Visitor::STATUS_DRINK)
            ->setParameter('genreId', $genre)
            ->execute();
    }

    public function moveToDance(AddToPlayList $event): void
    {
        $genre = $event->composition->getGenre();

        $this->entityManager->createQuery(
            'update App\Model\Bar\Entity\Visitor\Visitor v set v.status = :visitorStatus
            where :genreId MEMBER OF v.genres'
        )
            ->setParameter('visitorStatus', Visitor::STATUS_DANCE)
            ->setParameter('genreId', $genre)
            ->execute();
    }
}