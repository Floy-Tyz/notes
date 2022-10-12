<?php

namespace App\Model\Note\Http\Request;

use App\Infrastructure\Http\Request\RequestJsonDataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

class UpdateApiNoteData implements RequestJsonDataInterface
{
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Type('string'),
        new Assert\Length(max: 255),
    ])]
    private string $name;

    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Type('array'),
        new Assert\All([
            new Assert\Collection([
                'id' => [
                    new Assert\NotBlank(),
                    new Assert\Type('integer'),
                ],
                'name' => [
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                ],
                'checked' => [
                    new Assert\Type('boolean'),
                ],
            ])
        ]),
    ])]
    #[OA\Property(ref: '#/components/schemas/update-points')]
    private array $points;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getPoints(): array
    {
        return $this->points;
    }

    /**
     * @param array $points
     */
    public function setPoints(array $points): void
    {
        $this->points = $points;
    }
}