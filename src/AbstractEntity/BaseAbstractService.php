<?php

namespace App\AbstractEntity;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

abstract class BaseAbstractService implements ServiceSubscriberInterface
{
    /** @var ContainerInterface */
    protected ContainerInterface $container;

    /** @var EntityManagerInterface */
    protected EntityManagerInterface $entityManager;

    /**
     * @return array
     */
    public static function getSubscribedServices(): array
    {
        return [
            'entity_manager' => '?'.EntityManagerInterface::class,
            'parameter_bag' => '?'.ContainerBagInterface::class,
        ];
    }

    /**
     * @internal
     * @required
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    /**
     * @required
     *
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getParameter(string $name): mixed
    {
        if (!$this->container->has('parameter_bag')) {
            throw new ServiceNotFoundException('parameter_bag.', null, null, [], sprintf('The "%s::getParameter()" method is missing a parameter bag to work properly. Did you forget to register your controller as a service subscriber? This can be fixed either by using autoconfiguration or by manually wiring a "parameter_bag" in the service locator passed to the controller.', static::class));
        }

        return $this->container->get('parameter_bag')->get($name);
    }

    /**
     * @param string $id
     * @return bool
     */
    protected function has(string $id): bool
    {
        return $this->container->has($id);
    }

    /**
     * @param string $id
     * @return object
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function get(string $id): object
    {
        return $this->container->get($id);
    }

}