<?php

namespace App\Infrastructure\AbstractClass;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Twig\Extension\AbstractExtension;

abstract class BaseAbstractExtension extends AbstractExtension
{
    /** @var EntityManagerInterface $entityManager */
    protected EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
