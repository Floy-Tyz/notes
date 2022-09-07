<?php

namespace App\Service\Article\DataTransferObject;

use Symfony\Component\HttpFoundation\Request;

class CreateUpdateApiArticleDto
{
    /** @var string */
    private string $name;

    /** @var int */
    private int $categoryId;

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

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public static function fromRequest(Request $request): self
    {
        $request = $request->request;

        $dto = new self();

        $dto->setName($request->get('name'));
        $dto->setCategoryId($request->get('category_id'));
//        $dto->setPublish($request->get('publish'));

        return $dto;
    }
}