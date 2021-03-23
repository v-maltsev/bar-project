<?php

declare(strict_types=1);

namespace App\Controller\Api\Bar;

use App\Controller\Api\PrettyJsonResponse;
use App\Model\Bar\Entity\PlayList\PlayList;
use App\Model\Bar\Entity\PlayList\PlayListRepository;
use App\Model\Bar\Entity\Visitor\Visitor;
use App\Model\Bar\Entity\Visitor\VisitorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api/bar", name="api.bar")
 */
class BarController extends AbstractController
{

    private PlayListRepository $playListRepository;
    private VisitorRepository $visitorRepository;

    public function __construct(PlayListRepository $playListRepository, VisitorRepository $visitorRepository)
    {
        $this->playListRepository = $playListRepository;
        $this->visitorRepository = $visitorRepository;
    }
    /**
     * @Route ("", name="", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        $jsonArray = [];

        $jsonArray['current_composition'] = $this->getCurrentComposition();
        $jsonArray['visitor_dance'] = $this->getVisitorByStatus(Visitor::STATUS_DANCE);
        $jsonArray['visitor_drink'] = $this->getVisitorByStatus(Visitor::STATUS_DRINK);

        return new PrettyJsonResponse($jsonArray);
    }

    /**
     * @return array|null
     */
    private function getCurrentComposition(): ?array
    {
        $result = null;
        $playList = $this->playListRepository->findLast();
        if ($playList instanceof PlayList) {
            $result = [
                'id' => $playList->getComposition()->getId(),
                'name' => $playList->getComposition()->getName(),
                'genre' => [
                    'id' => $playList->getComposition()->getGenre()->getId(),
                    'name' => $playList->getComposition()->getGenre()->getName(),
                ]
            ];
        }

        return $result;
    }

    /**
     * @param int $status
     * @return array
     */
    private function getVisitorByStatus(int $status): array
    {
        $visitors = $this->visitorRepository->findAllByStatus($status);
        return array_map(
            static function (Visitor $visitor) {
                return [
                    'id' => $visitor->getId(),
                    'name' => $visitor->getName(),
                ];
            }, $visitors
        );
    }
}