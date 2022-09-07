<?php

namespace App\Service\Article\Serializer;

use App\Serializer\ApiSerializer;
use App\Service\Article\Normalizer\ArticleApiNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ArticleApiSerializer extends ApiSerializer
{
    public function __construct(ArticleApiNormalizer $articleApiNormalizer)
    {
        parent::__construct(new Serializer([$articleApiNormalizer], [new JsonEncoder()]));
    }
}