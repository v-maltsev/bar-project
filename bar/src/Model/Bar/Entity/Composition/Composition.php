<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\Composition;

use App\Model\Bar\Entity\Genre\Genre;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Composition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="composition.name.not_blank")
     */
    private ?string $name = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Bar\Entity\Genre\Genre")
     */
    private ?Genre $genre = null;

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

    public function getGenre(): ?Genre
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): void
    {
        $this->genre = $genre;
    }
}