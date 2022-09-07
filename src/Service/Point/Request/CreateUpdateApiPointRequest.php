<?php

namespace App\Service\Point\Request;

use App\Request\RequestValidation;
use App\Service\Point\DataTransferObject\CreateUpdateApiPointDto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUpdateApiPointRequest extends RequestValidation
{
//    /**
//     * @return CreateUpdateApiPointDto
//     */
//    public function getDTO(): CreateUpdateApiPointDto
//    {
//        return CreateUpdateApiPointDto::fromRequest($this->request);
//    }

    /**
     * @param $data
     * @return array
     */
    protected function getConstraint($data): array
    {
        return [
            //todo
        ];
    }
}