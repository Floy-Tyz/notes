<?php

namespace App\Service\Note\DataTransferObject;

use Symfony\Component\HttpFoundation\Request;

class CreateUpdateApiNoteDto
{
    /** @var string */
    private string $name;

    /** @var array */
    private array $points;

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

    public static function fromRequest(Request $request): self
    {
        $request = $request->request;

        $dto = new self();

        $dto->setName($request->get('name'));
        $dto->setPoints($request->all('points'));

        return $dto;
    }
}