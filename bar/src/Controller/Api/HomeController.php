<?php

declare(strict_types=1);

namespace App\Controller\Api;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Bar API",
 *      description="HTTP JSON API"
 * )
 * @OA\Server(
 *     url="/api"
 * )
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="home", methods={"GET"})
     * @return Response
     */
    public function home(): Response
    {
        return $this->json([
            'name' => 'JSON API',
        ]);
    }
}