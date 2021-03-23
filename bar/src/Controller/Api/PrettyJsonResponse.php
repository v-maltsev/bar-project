<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class PrettyJsonResponse extends JsonResponse
{
    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct($data, $status, $headers,$json);

        self::setEncodingOptions(self::getEncodingOptions() | JSON_PRETTY_PRINT);
    }
}