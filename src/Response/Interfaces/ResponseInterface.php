<?php

namespace App\Response\Interfaces;

interface ResponseInterface
{
    public function response(mixed $data, array $context, int $code, string $format);

    public function support(mixed $data): bool;
}