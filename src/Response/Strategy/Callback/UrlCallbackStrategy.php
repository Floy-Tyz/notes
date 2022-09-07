<?php

namespace App\Response\Strategy\Callback;

use App\Response\Interfaces\CallbackInterface;
use App\Service\Sitemap\Interfaces\EntitySitemapInterface;
use DateTime;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlCallbackStrategy implements CallbackInterface
{
    public function __construct(
        private readonly UrlGeneratorInterface $router
    ){}

    public function callback(): array
    {
        $callback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            if ($innerObject instanceof EntitySitemapInterface){
                dd();
            }
            return $innerObject instanceof EntitySitemapInterface ? $this->router->generate($innerObject->getRoute(), $innerObject->getUrlParameters()) : $innerObject;
        };

        return [
            'urlParameters' => $callback,
        ];
    }
}