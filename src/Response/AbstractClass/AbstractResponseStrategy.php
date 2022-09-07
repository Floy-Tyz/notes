<?php

namespace App\Response\AbstractClass;

use App\Response\Interfaces\ResponseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResponseStrategy implements ResponseInterface
{
    /**
     * @param mixed $content
     * @param int $code
     * @return Response
     */
    public function makeResponse(mixed $content, int $code = 200): Response
    {
        $response = new JsonResponse;

        $response->setContent($content);

        $response->setStatusCode($code);

        return $response;
    }
}