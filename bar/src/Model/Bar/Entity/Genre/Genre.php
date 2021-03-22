<?php

declare(strict_types=1);

namespace App\Model\Bar\Entity\Genre;

use App\Model\Bar\Entity\Composition\Composition;
use App\Model\Bar\Entity\Visitor\Visitor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Genre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="genre.name.not_blank")
     */
    private ?string $name = null;
    /**
     * @ORM\ManyToMany(targetEntity="App\Model\Bar\Entity\Visitor\Visitor", mappedBy="genres")
     * @var Visitor[]|Collection
     */
    private Collection $visitors;

    /**
     * @ORM\OneToMany(targetEntity="App\Model\Bar\Entity\Composition\Composition", mappedBy="genre")
     * @var Composition[]|Collection
     */
    private Collection $compositions;

    public function __construct()
    {
        $this->visitors = new ArrayCollection();
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

    public function addVisitor(Visitor $visitor): void
    {
        if (!$this->visitors->contains($visitor)) {
            $this->visitors->add($visitor);
        }
    }

    /**
     * @return Visitor[]|Collection
     */
    public function getVisitors(): array
    {
        return $this->visitors->toArray();
    }

    /**
     * @return Composition[]|Collection
     */
    public function getCompositions(): array
    {
        return $this->compositions->toArray();
    }
}