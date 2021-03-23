<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\Visitor;

use App\Model\Bar\Entity\Genre\Genre;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Visitor
{
    public const STATUS_DRINK = 0;
    public const STATUS_DANCE = 1;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="visitor.name.not_blank")
     */
    private ?string $name = null;
    /**
     * @var Collection|Genre[]
     *
     * @ORM\ManyToMany(targetEntity="App\Model\Bar\Entity\Genre\Genre", inversedBy="visitors")
     */
    private Collection $genres;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private int $status;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->status = self::STATUS_DRINK;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function hasGenre(Genre $genre): bool
    {
        return $this->genres->contains($genre);
    }

    public function addGenre(Genre $genre): void
    {
        if (!$this->genres->contains($genre)) {
            $genre->addVisitor($this);
            $this->genres->add($genre);
        }
    }

    public function removeGenre(Genre $genre): void
    {
        if (!$this->genres->contains($genre)) {
            return;
        }
        $this->genres->removeElement($genre);
    }

    /**
     * @return Genre[]|Collection
     */
    public function getGenres(): array
    {
        return $this->genres->toArray();
    }

    public function dance():void
    {
        $this->status = self::STATUS_DANCE;
    }

    public function drink(): void
    {
        $this->status = self::STATUS_DRINK;
    }
}