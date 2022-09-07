<?php

namespace App\Service\Note\Request;

use App\Request\RequestValidation;
use App\Service\Note\DataTransferObject\CreateUpdateApiNoteDto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUpdateApiNoteRequest extends RequestValidation
{
    /**
     * @return CreateUpdateApiNoteDto
     */
    public function getDTO(): CreateUpdateApiNoteDto
    {
        return CreateUpdateApiNoteDto::fromRequest($this->request);
    }

    /**
     * @param $data
     * @return array
     */
    protected function getConstraint($data): array
    {
        return [

            'name' => [

                new Assert\NotBlank([
                    'message' => 'Обязательное поле'
                ]),

                new Assert\Length([
                    'min' => 2, 'max' => 255,
                    'maxMessage' => 'Не более 255 символов',
                    'minMessage' => 'Минимум 2 символа'
                ])
            ],
        ];
    }
}