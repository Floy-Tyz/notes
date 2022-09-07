<?php

namespace App\Service\Category\Normalizer;

use App\Serializer\Builder\SerializerBuilder;
use Symfony\Component\Serializer\Annotation\Groups;

class CategoryNormalizerBuilder
{
    #[Groups('api')]
    public static function getApiSerialization(SerializerBuilder $builder): array
    {
//        $builder->addRelation('children', ['id', 'name']);
        $builder->addRelation('parent', ['id', 'name']);
        $builder->addRelation('parent.children', ['id', 'name', 'slug']);

        return $builder->normalizerParts;
    }
}