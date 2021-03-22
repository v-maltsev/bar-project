<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\PlayList;

use App\Model\AggregateRoot;
use App\Model\Bar\Entity\Composition\Composition;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PlayList implements AggregateRoot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;
    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Bar\Entity\Composition\Composition")
     */
    private Composition $composition;

    private array $recordedEvents = [];

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setComposition(Composition $composition): void
    {
        $this->composition = $composition;
        $this->recordEvent(new Event\AddToPlayList($composition));
    }

    public function getComposition(): Composition
    {
        return $this->composition;
    }

    protected function recordEvent(object $event): void
    {
        $this->recordedEvents[] = $event;
    }

    public function releaseEvents(): array
    {
        $events = $this->recordedEvents;
        $this->recordedEvents = [];
        return $events;
    }
}