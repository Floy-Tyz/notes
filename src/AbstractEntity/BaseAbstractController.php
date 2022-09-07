<?php

namespace App\AbstractEntity;

use App\Response\AppResponseFacade;
use App\Serializer\AppSerializer;
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

    /** @var AppSerializer */
    protected AppSerializer $serializer;

    /** @var AppResponseFacade */
    protected AppResponseFacade $response;

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
     * @param EntityManagerInterface $entityManager
     */
    #[Required]
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param AppSerializer $serializer
     */
    #[Required]
    public function setSerializer(AppSerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param AppResponseFacade $appResponseFacade
     */
    #[Required]
    public function setResponseFacade(AppResponseFacade $appResponseFacade)
    {
        $this->response = $appResponseFacade;
    }
}
