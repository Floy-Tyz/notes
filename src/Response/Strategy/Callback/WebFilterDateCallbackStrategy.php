<?php

namespace App\Response\Strategy\Callback;

use App\Response\Interfaces\CallbackInterface;
use App\Service\Utils\DateConverter;
use DateTime;

class WebFilterDateCallbackStrategy implements CallbackInterface
{
    public function callback(): array
    {
        $timestampCallback = function ($innerObject, $outerObject, string $attributeName, string $format = null, array $context = []) {
            return $innerObject instanceof DateTime
                ? [
                    'month' => DateConverter::getMonth($innerObject->format('n'), ['case' => "genitive", 'register' => "upper"]),
                    'day_of_week' => DateConverter::getDay($innerObject->format('N')),
                    'year' => $innerObject->format('Y'),
                    'day' => $innerObject->format('d'),
                ] : $innerObject;
        };

        return [
            'checkin' => $timestampCallback,
            'checkout' => $timestampCallback,
        ];
    }
}