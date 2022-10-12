<?php

namespace App\Infrastructure\AbstractClass;

use App\Infrastructure\Http\Services\Serializer\ModelSerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class BaseAbstractService
{
    /** @var EntityManagerInterface $entityManager */
    protected EntityManagerInterface $entityManager;

    /** @var ModelSerializerInterface */
    protected ModelSerializerInterface $serializer;

    /**
     * @param EntityManagerInterface $entityManager
     */
    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    #[Required]
    public function setSerializer(ModelSerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}