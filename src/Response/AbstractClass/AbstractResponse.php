<?php

namespace App\Response\AbstractClass;

use App\Response\Resolver\ResponsesResolver;
use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractResponse
{
    private ResponsesResolver $resolver;

    /**
     * @param ResponsesResolver $resolver
     * @return void
     */
    #[Required]
    public function setResponseResolver(ResponsesResolver $resolver): void
    {
        $this->resolver = $resolver;
    }

    /**
     * @param array|string|int $data
     * @param array $context
     * @param int $code
     * @param string $format
     * @return Response
     */
    public function response(mixed $data, array $context = [], int $code = 200, string $format = 'json'): Response
    {
        foreach ($this->resolver->getResponseStrategies() as $response){

            if ($response->support($data)){

                return $response->response($data, $context, $code, $format);
            }
        }

        return throw new LogicException('Strategy not found for data');
    }
}