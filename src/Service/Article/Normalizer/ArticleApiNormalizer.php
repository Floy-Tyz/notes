<?php

namespace App\Service\Article\Normalizer;

use App\Entity\Article;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ArticleApiNormalizer implements NormalizerAwareInterface, NormalizerInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Article $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'slug' => $object->getSlug(),
            'content' => $object->getContent(),
            'category' => [
                'id' => $object->getCategory()->getId(),
                'name' => $object->getCategory()->getName(),
                'slug' => $object->getCategory()->getSlug(),
            ],
            'created_at' => $object->getCreatedAt()->format('d-m-Y'),
            'updated_at' => $object->getUpdatedAt()->format('d-m-Y'),
        ];
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @param array $context
     * @return bool
     */
    public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
    {
        return $data instanceof Article;
    }
}