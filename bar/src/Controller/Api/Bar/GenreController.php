<?php

declare(strict_types=1);

namespace App\Controller\Api\Bar;

use App\Controller\Api\PrettyJsonResponse;
use App\Model\Bar\Entity\Composition\Composition;
use App\Model\Bar\Entity\Genre\Genre;
use App\Model\Bar\Entity\Genre\GenreRepository;
use App\Model\Bar\Entity\Visitor\Visitor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/genre", name="api.genre")
 */
class GenreController extends AbstractController
{

    /**
     * @Route ("", name="", methods={"GET"})
     * @param GenreRepository $genreRepository
     * @return Response
     */
    public function index(GenreRepository $genreRepository):Response
    {
        $genreArray = $genreRepository->getAll();
        return new PrettyJsonResponse([
            'items' => array_map(
                static function (Genre $genre) {
                    return [
                        'id' => $genre->getId(),
                        'name' => $genre->getName(),
                    ];
                }, $genreArray
            )
        ]);
    }

    /**
     * @Route ("/{id}", name=".get", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     * @param GenreRepository $genreRepository
     * @return Response
     */
    public function getItem(int $id, GenreRepository $genreRepository): Response
    {
        $genre = $genreRepository->get($id);
        return new PrettyJsonResponse([
            'id' => $genre->getId(),
            'name' => $genre->getName(),
            'genres' => array_map(
                static function (Visitor $visitor) {
                    return [
                        'id' => $visitor->getId(),
                        'name' => $visitor->getName(),
                    ];
                }, $genre->getVisitors()
            ),
            'compositions' => array_map(
                static function (Composition $composition) {
                    return [
                        'id' => $composition->getId(),
                        'name' => $composition->getName(),
                    ];
                }, $genre->getCompositions()
            ),
        ]);
    }
}