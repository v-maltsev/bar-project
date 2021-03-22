<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Model\Bar\Entity\Composition\Composition;
use App\Model\Bar\Entity\Genre\Genre;
use App\Model\Bar\Entity\Visitor\Visitor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BarFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genre = $this->createGenre('Genre 1');
        $manager->persist($genre);

        $genre2 = $this->createGenre('Genre 2');
        $manager->persist($genre2);

        $genre3 = $this->createGenre('Genre 3');
        $manager->persist($genre3);

        $visitor = $this->createVisitor('Visitor 1');
        $visitor->addGenre($genre);
        $visitor->addGenre($genre2);
        $manager->persist($visitor);

        $visitor2 = $this->createVisitor('Visitor 2');
        $visitor2->addGenre($genre);
        $manager->persist($visitor2);

        $visitor3 = $this->createVisitor('Visitor 3');
        $visitor3->addGenre($genre2);
        $manager->persist($visitor3);

        $visitor4 = $this->createVisitor('Visitor 4');
        $visitor4->addGenre($genre3);
        $manager->persist($visitor4);

        $composition = $this->createComposition('Composition 1');
        $composition->setGenre($genre);
        $manager->persist($composition);

        $composition2 = $this->createComposition('Composition 2');
        $composition2->setGenre($genre);
        $manager->persist($composition2);

        $composition3 = $this->createComposition('Composition 3');
        $composition3->setGenre($genre);
        $manager->persist($composition3);

        $composition4 = $this->createComposition('Composition 4');
        $composition4->setGenre($genre2);
        $manager->persist($composition4);

        $composition5 = $this->createComposition('Composition 5');
        $composition5->setGenre($genre3);
        $manager->persist($composition5);

        $manager->flush();
    }

    private function createGenre(string $name)
    {
        $genre = new Genre();
        $genre->setName($name);
        return $genre;
    }

    private function createVisitor(string $name)
    {
        $visitor = new Visitor();
        $visitor->setName($name);
        return $visitor;
    }

    private function createComposition(string $name)
    {
        $composition = new Composition();
        $composition->setName($name);
        return $composition;
    }
}