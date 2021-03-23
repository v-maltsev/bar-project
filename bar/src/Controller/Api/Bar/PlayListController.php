<?php

declare(strict_types=1);

namespace App\Controller\Api\Bar;

use App\Controller\Api\PrettyJsonResponse;
use App\Model\Bar\Entity\PlayList\PlayListRepository;
use App\Model\Bar\UseCase\PlayList\Add;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/playlist", name="api.playlist")
 */
class PlayListController extends AbstractController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }
    
    /**
     * @Route("", name="", methods={"GET"})
     * @param PlayListRepository $playListRepository
     * @return Response
     */
    public function index(PlayListRepository $playListRepository): Response
    {
        $playList = $playListRepository->getLast();
        return new PrettyJsonResponse([
            'composition_id' => $playList->getComposition()->getId(),
            'composition_name' => $playList->getComposition()->getName(),
            'genre_name' => $playList->getComposition()->getGenre()->getName(),
        ]);
    }

    /**
     * @Route("/add", name=".add", methods={"PUT"})
     * @param Request $request
     * @param Add\Handler $handler
     * @return Response
     */
    public function addComposition(Request $request, Add\Handler $handler):Response
    {
        $data = json_decode($request->getContent(),true);
        $command = new Add\Command();
        $command->compositionId = $data['compositionId'];

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');
            return new JsonResponse($json, 400, [], true);
        }

        $handler->handle($command);

        return new PrettyJsonResponse([]);
    }
}