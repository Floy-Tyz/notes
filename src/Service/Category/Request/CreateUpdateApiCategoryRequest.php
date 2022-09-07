<?php

namespace App\Service\Category\Request;

use App\Request\RequestValidation;
use App\Service\Category\DataTransferObject\CreateUpdateApiCategoryDto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUpdateApiCategoryRequest extends RequestValidation
{
    /**
     * @return CreateUpdateApiCategoryDto
     */
    public function getDTO(): CreateUpdateApiCategoryDto
    {
        return CreateUpdateApiCategoryDto::fromRequest($this->request);
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

            'parent_id' => [

                new Assert\PositiveOrZero([
                    'message' => 'id радительской категории'
                ])
            ],

//            'description' => [
//
//                new Assert\Length([
//                    'min' => 0, 'max' => 65000,
//                    'maxMessage' => 'Не более 65000 символов',
//                    'minMessage' => 'Минимум 0 символов'
//                ])
//
//            ],
//
//            'publish' => [
//
//                new Assert\Type([
//                    'type' => 'boolean',
//                    'message' => 'Логическое значение'
//                ])
//            ],
        ];
    }
}