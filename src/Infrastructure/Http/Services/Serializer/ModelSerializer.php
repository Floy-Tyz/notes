<?php

namespace App\Infrastructure\Http\Services\Serializer;

use App\Infrastructure\Http\Exception\BusinessException;
use ArrayObject;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Serializer;

class ModelSerializer extends Serializer implements ModelSerializerInterface
{
    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|string|int|float|bool|ArrayObject|null
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array|string|int|float|bool|ArrayObject|null
    {
        try {
            return parent::normalize($object, $format, $context);
        }
        catch (ExceptionInterface $exception){
            throw new BusinessException($exception->getMessage());
        }
    }

}