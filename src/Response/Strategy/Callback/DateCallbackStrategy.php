<?php

namespace App\Response\Strategy\Callback;

use App\Response\Interfaces\CallbackInterface;
use DateTime;

class DateCallbackStrategy implements CallbackInterface
{
    public function callback(): array
    {
        $timestampCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof DateTime ? $innerObject->format('Y-m-d') : '';
        };

        return [
            'date' => $timestampCallback,
        ];
    }
}