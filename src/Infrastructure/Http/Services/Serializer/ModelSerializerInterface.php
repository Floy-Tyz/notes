<?php

namespace App\Infrastructure\Http\Services\Serializer;

use ArrayObject;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

interface ModelSerializerInterface extends SerializerInterface, NormalizerInterface, DenormalizerInterface
{
    /**
     * Normalizes an object into a set of arrays/scalars.
     * @param mixed $object Object to normalize
     * @param string|null $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     * @return array|string|int|float|bool|ArrayObject|null
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array|string|int|float|bool|ArrayObject|null;

    /**
     * Denormalizes data back into an object of the given class.
     * @param mixed $data Request to restore
     * @param string $type The expected class to instantiate
     * @param string|null $format Format the given data was extracted from
     * @param array $context Options available to the denormalizer
     * @return mixed
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed;
}