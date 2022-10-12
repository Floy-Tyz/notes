<?php

namespace App\Infrastructure\Http\Services\Serializer;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ModelSerializerFactory
{

    public function __invoke(): ModelSerializer
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());

        $context = [  ];

        $normalizer = new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, null, null, null, $context);

        return new ModelSerializer([$normalizer], ['json' => new JsonEncoder()]);
    }
}