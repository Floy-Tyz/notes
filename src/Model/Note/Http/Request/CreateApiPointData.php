<?php

namespace App\Model\Note\Http\Request;

use App\Infrastructure\Http\Request\RequestJsonDataInterface;
use Symfony\Component\Validator\Constraints as Assert;
use OpenApi\Attributes as OA;

class CreateApiPointData implements RequestJsonDataInterface
{
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Type('string'),
        new Assert\Length(max: 255),
    ])]
    private string $name;

    #[Assert\Sequentially([
        new Assert\Type('boolean'),
    ])]
    private string $checked;

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
     * @return string
     */
    public function getChecked(): string
    {
        return $this->checked;
    }

    /**
     * @param string $checked
     */
    public function setChecked(string $checked): void
    {
        $this->checked = $checked;
    }
}