<?php

namespace App\Response\Context;

use App\Response\AbstractClass\AbstractResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiContext extends AbstractResponse
{
    /**
     * @param mixed $data
     * @param array $context
     * @param int $code
     * @param string $format
     * @return Response
     */
    public function success(mixed $data, array $context = [], int $code = 200, string $format = 'json'): Response
    {
//        $context['groups'] = ['api', ...array_key_exists('groups', $context) ? $context['groups'] : []];
        $context['groups'] = 'api';

        return parent::response($data, $context, $code, $format);
    }

    /**
     * @param mixed $data
     * @param array $context
     * @param int $code
     * @param string $format
     * @return Response
     */
    public function failed(mixed $data, array $context = [], int $code = 500, string $format = 'json'): Response
    {
        $context['groups'] = 'api';

        return parent::response($data, $context, $code, $format);
    }
}