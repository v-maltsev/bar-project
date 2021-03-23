<?php

declare(strict_types=1);

namespace App\Controller\Api\Bar;

use App\Controller\Api\PrettyJsonResponse;
use App\Model\Bar\Entity\Genre\Genre;
use App\Model\Bar\Entity\Visitor\Visitor;
use App\Model\Bar\Entity\Visitor\VisitorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/visitor", name="api.visitor")
 */
class VisitorController extends AbstractController
{
    /**
     * @Route ("", name="", methods={"GET"})
     * @param VisitorRepository $visitorRepository
     * @return Response
     */
    public function index(VisitorRepository $visitorRepository):Response
    {
        $visitorArray = $visitorRepository->getAll();
        return $this->getResponseForAll($visitorArray);
    }

    /**
     * @Route ("/dance", name=".dance", methods={"GET"})
     * @param VisitorRepository $visitorRepository
     * @return Response
     */
    public function getDance(VisitorRepository $visitorRepository):Response
    {
        $visitorArray = $visitorRepository->findAllByStatus(Visitor::STATUS_DANCE);
        return $this->getResponseForAll($visitorArray);
    }

    /**
     * @Route ("/drink", name=".drink", methods={"GET"})
     * @param VisitorRepository $visitorRepository
     * @return Response
     */
    public function getDrink(VisitorRepository $visitorRepository):Response
    {
        $visitorArray = $visitorRepository->findAllByStatus(Visitor::STATUS_DRINK);
        return $this->getResponseForAll($visitorArray);
    }

    /**
     * @Route ("/{id}", name=".get", methods={"GET"}, requirements={"id"="\d+"})
     * @param int $id
     * @param VisitorRepository $visitorRepository
     * @return Response
     */
    public function getItem(int $id, VisitorRepository $visitorRepository): Response
    {
        $visitor = $visitorRepository->get($id);
        return new PrettyJsonResponse([
            'id' => $visitor->getId(),
            'name' => $visitor->getName(),
            'status' => $visitor->getStatus(),
            'genres' => array_map(
                static function (Genre $genre) {
                    return [
                        'id' => $genre->getId(),
                        'name' => $genre->getName(),
                    ];
                }, $visitor->getGenres()
            ),
        ]);
    }

    /**
     * @param Visitor[] $visitorArray
     * @return JsonResponse
     */
    private function getResponseForAll( array $visitorArray): JsonResponse
    {
        return new PrettyJsonResponse([
            'items' => array_map(
                static function (Visitor $visitor) {
                    return [
                        'id' => $visitor->getId(),
                        'name' => $visitor->getName(),
                        'status' => $visitor->getStatus(),
                    ];
                }, $visitorArray
            )
        ]);
    }
}