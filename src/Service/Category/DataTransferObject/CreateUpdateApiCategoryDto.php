<?php

namespace App\Service\Category\DataTransferObject;

use Symfony\Component\HttpFoundation\Request;

class CreateUpdateApiCategoryDto
{
    /** @var string */
    private string $name;

    /** @var integer */
    private int $parentCategoryId;

    /** @var string */
    private string $description;

    /** @var boolean */
    private bool $publish;

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
     * @return int
     */
    public function getParentCategoryId(): int
    {
        return $this->parentCategoryId;
    }

    /**
     * @param int $parentCategoryId
     */
    public function setParentCategoryId(int $parentCategoryId): void
    {
        $this->parentCategoryId = $parentCategoryId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return bool
     */
    public function isPublish(): bool
    {
        return $this->publish;
    }

    /**
     * @param bool $publish
     */
    public function setPublish(bool $publish): void
    {
        $this->publish = $publish;
    }

    public static function fromRequest(Request $request): self
    {
        $request = $request->request;

        $dto = new self();

        $dto->setName($request->get('name'));
        $dto->setParentCategoryId($request->get('parent_id'));
//        $dto->setDescription($request->get('description'));
//        $dto->setPublish($request->get('publish'));

        return $dto;
    }
}