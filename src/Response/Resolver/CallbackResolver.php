<?php

namespace App\Response\Resolver;

use App\Response\Interfaces\CallbackInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class CallbackResolver
{
    /** @var iterable  */
    private iterable $iterableCallbacks;

    /**
     * @param iterable $iterableCallbacks
     */
    public function __construct(
        #[TaggedIterator('app.response.callback')] iterable $iterableCallbacks
    ){
        $this->iterableCallbacks = $iterableCallbacks;
    }

    /**
     * @return array<CallbackInterface>
     */
    public function getCallbacks(): array
    {
        /** @var CallbackInterface $callback */
        foreach($this->iterableCallbacks as $callback) {
            $callbacks = [...$callbacks ?? [], ...$callback->callback()];
        }
        return $callbacks ?? [];
    }

}