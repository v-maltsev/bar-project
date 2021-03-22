<?php

declare(strict_types=1);

namespace App\Controller\Api\Bar;

use App\Model\Bar\Entity\Composition\Composition;
use App\Model\Bar\Entity\Composition\CompositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/composition", name="api.composition")
 */
class CompositionController extends AbstractController
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
     * @param CompositionRepository $compositionRepository
     * @return Response
     */
    public function index(CompositionRepository $compositionRepository):Response
    {
        $compositionArray = $compositionRepository->getAll();
        return $this->json([
            'items' => array_map(
                static function (Composition $composition) {
                    return [
                        'id' => $composition->getId(),
                        'name' => $composition->getName(),
                        'genre_name' => $composition->getGenre()->getName()
                    ];
                }, $compositionArray
            )
        ]);
    }
}