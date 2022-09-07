<?php

namespace App\Response\Resolver;

use App\Response\Interfaces\ResponseInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class ResponsesResolver
{
    /** @var iterable  */
    private iterable $iterableResponses;

    /**
     * @param iterable $iterableResponses
     */
    public function __construct(
        #[TaggedIterator('app.response.strategy')] iterable $iterableResponses
    ){
        $this->iterableResponses = $iterableResponses;
    }

    /**
     * @return array<ResponseInterface>
     */
    public function getResponseStrategies(): array
    {
        /** @var ResponseInterface $response */
        foreach($this->iterableResponses as $response) {
            $responses[] = $response;
        }
        return $responses ?? [];
    }

}