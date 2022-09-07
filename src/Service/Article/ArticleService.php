<?php

namespace App\Service\Article;

use App\AbstractEntity\BaseAbstractService;
use App\Entity\Article;
use App\Repository\CategoryRepository;
use App\Service\Article\DataTransferObject\CreateUpdateApiArticleDto;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleService extends BaseAbstractService
{
    /**
     * @param CategoryRepository $categoryRepository
     * @param SluggerInterface $slugger
     */
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private readonly SluggerInterface $slugger,
    ){}

    /**
     * @param Article $article
     * @param CreateUpdateApiArticleDto $dto
     * @return void
     */
    public function createOrUpdateArticle(Article $article, CreateUpdateApiArticleDto $dto): void
    {
        $article->setName($dto->getName());
        $article->setSlug($this->slugger->slug(mb_strtolower($dto->getName())));

        $category = $this->categoryRepository->find($dto->getCategoryId());
        $article->setCategory($category);

        $this->entityManager->persist($article);
        $this->entityManager->flush();
    }
}