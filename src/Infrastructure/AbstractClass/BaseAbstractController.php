<?php

namespace App\Infrastructure\AbstractClass;

use App\Infrastructure\Http\Services\Serializer\ModelSerializerInterface;
use App\Traits\ResponseStatusTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

abstract class BaseAbstractController extends AbstractController implements ServiceSubscriberInterface
{
    use ResponseStatusTrait;

    /** @var EntityManagerInterface */
    protected EntityManagerInterface $entityManager;

    protected ModelSerializerInterface $serializer;

    /**
     * @return array
     */
    public static function getSubscribedServices(): array
    {
        return array_merge([
            'event_dispatcher' => '?'.EventDispatcherInterface::class,
        ]);
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Required]
    public function setSerializer(ModelSerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }
}
