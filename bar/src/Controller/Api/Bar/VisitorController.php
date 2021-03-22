<?php

declare(strict_types=1);

namespace App\Controller\Api\Bar;

use App\Model\Bar\Entity\Genre\Genre;
use App\Model\Bar\Entity\Visitor\Visitor;
use App\Model\Bar\Entity\Visitor\VisitorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/visitor", name="api.visitor")
 */
class VisitorController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @Route ("", name="", methods={"GET"})
     * @param VisitorRepository $visitorRepository
     * @return Response
     */
    public function index(VisitorRepository $visitorRepository):Response
    {
        $visitorArray = $visitorRepository->getAll();
        return $this->json([
            'items' => array_map(
                static function (Visitor $visitor) {
                    return [
                        'id' => $visitor->getId(),
                        'name' => $visitor->getName(),
                    ];
                }, $visitorArray
            )
        ]);
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
        return $this->json([
            'id' => $visitor->getId(),
            'name' => $visitor->getName(),
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
}