<?php

namespace App\Infrastructure\Http\EventListener;

use App\Infrastructure\Http\Exception\BusinessException;
use App\Traits\ResponseStatusTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionListener
{
    use ResponseStatusTrait;

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof MethodNotAllowedHttpException) {

            $response = new Response();

            $response->setStatusCode(Response::HTTP_NOT_FOUND);

            $event->setResponse($response);
        }

        /** @var BusinessException $exception */
        if ($exception instanceof BusinessException) {

            $event->allowCustomResponseCode();

            $response = $this->failed(['message' => $exception->getMessage(), 'errors' => $exception->getErrors() ]);

            $event->setResponse($response);

            $event->stopPropagation();
        }

        /** @var ValidationFailedException $exception */
        if ($exception instanceof ValidationFailedException) {

            $event->allowCustomResponseCode();

            $errors = [];

            /** @var ConstraintViolation $violation */
            foreach ($exception->getViolations() as $violation)
            {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }

            $response = $this->failed(['message' => $exception->getValue(), 'errors' => $errors ]);

            $event->setResponse($response);

            $event->stopPropagation();
        }
    }
}