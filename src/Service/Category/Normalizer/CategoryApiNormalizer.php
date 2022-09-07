<?php

namespace App\Service\Category\Normalizer;

use App\Entity\Category;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CategoryApiNormalizer implements NormalizerAwareInterface, NormalizerInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Category $object
     * @param string|null $format
     * @param array $context
     * @return array
     * @throws
     */
    public function normalize($object, string $format = null, array $context = []): array
    {
        $parent = $object->getParent();

        return [
            'id' => $object->getId(),
            'name' => $object->getName(),
            'slug' => $object->getSlug(),
            'has_children' => $object->hasChildren(),
            'parent' => $parent ?
                [
                    'id' => $parent->getId(),
                    'name' => $parent->getName(),
                ]
            : null,
            'path' => array_slice(explode('/', $object->getPath()), 1, -1),
            'articles_count' => count($object->getArticles()),
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
        return $data instanceof Category;
    }
}