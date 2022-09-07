<?php

namespace App\Service\Category\Serializer;

use App\Serializer\ApiSerializer;
use App\Service\Category\Normalizer\CategoryApiNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class CategoryApiSerializer extends ApiSerializer
{
    public function __construct(CategoryApiNormalizer $categoryApiNormalizer)
    {
        parent::__construct(new Serializer([$categoryApiNormalizer], [new JsonEncoder()]));
    }
}