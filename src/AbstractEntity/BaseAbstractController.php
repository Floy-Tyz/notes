<?php

namespace App\AbstractEntity;

use App\Serializer\RelationSerializer;
use App\Serializer\Interfaces\SerializerManagerInterface;
use App\Traits\ResponseStatusTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

abstract class BaseAbstractController extends AbstractController implements ServiceSubscriberInterface
{
    use ResponseStatusTrait;

    /** @var EntityManagerInterface */
    protected EntityManagerInterface $entityManager;

    /** @var RelationSerializer */
    protected RelationSerializer $serializer;

    /**
     * @return array
     */
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'event_dispatcher' => '?'.EventDispatcherInterface::class,
        ]);
    }

    /**
     * @required
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @required
     * @param SerializerManagerInterface $serializerManager
     */
    public function setSerializer(SerializerManagerInterface $serializerManager)
    {
        $this->serializer = $serializerManager->getSerializer();
    }
}
