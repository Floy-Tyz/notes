<?php

namespace App\Response;

use App\Response\AbstractClass\AbstractResponse;
use App\Response\Context\ApiContext;
use App\Response\Context\WebContext;

class AppResponseFacade extends AbstractResponse
{
    /**
     * @param ApiContext $api
     * @param WebContext $web
     */
    public function __construct(
        public readonly ApiContext $api,
        public readonly WebContext $web,
    ){}
}