<?php

namespace App\Service\Article\Request;

use App\Request\RequestValidation;
use App\Service\Article\DataTransferObject\CreateUpdateApiArticleDto;
use Symfony\Component\Validator\Constraints as Assert;

class CreateUpdateApiArticleRequest extends RequestValidation
{
    /**
     * @return CreateUpdateApiArticleDto
     */
    public function getDTO(): CreateUpdateApiArticleDto
    {
        return CreateUpdateApiArticleDto::fromRequest($this->request);
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

            'category_id' => [

                new Assert\PositiveOrZero([
                    'message' => 'id категории'
                ])
            ],

        ];
    }
}