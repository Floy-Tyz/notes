<?php

namespace App\EventListener;

use App\Request\RequestValidation;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

class RequestValidatorTriggerListener
{
    public function onKernelControllerArguments(ControllerArgumentsEvent $event): void
    {
        foreach ($event->getArguments() as $argument) {

            if ($argument instanceof RequestValidation) {

                $argument->validate();
            }
        }
    }
}