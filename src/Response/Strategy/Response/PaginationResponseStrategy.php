<?php

namespace App\Response\Strategy\Response;

use App\Response\AbstractClass\AbstractResponseStrategy;
use App\Serializer\AppSerializer;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\HttpFoundation\Response;

class PaginationResponseStrategy extends AbstractResponseStrategy
{
    public function __construct(
        private readonly AppSerializer $serializer
    ){}

    public function response(mixed $data, array $context, int $code, string $format): Response
    {
        $items = [
            'success' => true,
            'entities' => $data,
            'pagination' => [
                'current_page' => $data->getCurrentPageNumber(),
                'last_page' => intval(ceil($data->getTotalItemCount() / $data->getItemNumberPerPage())),
                'total' => $data->getTotalItemCount()
            ],
        ];

        $groups = array_key_exists('groups', $context) ? $context['groups'] : [];

        return $this->makeResponse($this->serializer->serialize($items, ['groups' => $groups], $format));
    }

    public function support(mixed $data): bool
    {
        return $data instanceof PaginationInterface;
    }
}