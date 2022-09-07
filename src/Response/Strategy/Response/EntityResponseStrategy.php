<?php

namespace App\Response\Strategy\Response;

use App\Response\AbstractClass\AbstractResponseStrategy;
use App\Response\Collection\EntityArrayCollection;
use App\Serializer\AppSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class EntityResponseStrategy extends AbstractResponseStrategy
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param AppSerializer $serializer
     */
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AppSerializer $serializer,
    ){}

    /**
     * @param mixed $data
     * @param array $context
     * @param int $code
     * @param string $format
     * @return Response
     */
    public function response(mixed $data, array $context, int $code, string $format): Response
    {
        $items = [
            'success' => true,
            is_array($data) || $data instanceof EntityArrayCollection ? 'entities' : 'entity' => $data
        ];
        if (array_key_exists('extra', $context)){

            $items = [...$items, ...$context['extra']];
        }

        $groups = array_key_exists('groups', $context) ? $context['groups'] : [];

        return $this->makeResponse($this->serializer->serialize($items, $groups, $format));
    }

    /**
     * @param mixed $data
     * @return bool
     */
    public function support(mixed $data): bool
    {
        return ($data instanceof EntityArrayCollection) || (is_object($data) && !$this->entityManager->getMetadataFactory()->isTransient(get_class($data)));
    }
}