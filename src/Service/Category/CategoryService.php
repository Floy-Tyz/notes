<?php

namespace App\Service\Category;

use App\AbstractEntity\BaseAbstractService;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\Category\DataTransferObject\CreateUpdateApiCategoryDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryService extends BaseAbstractService
{
    /**
     * @param CategoryRepository $repository
     * @param SluggerInterface $slugger
     */
    public function __construct(
        private readonly CategoryRepository $repository,
        private readonly SluggerInterface $slugger,
    ){}

    /**
     * @param Category $category
     * @param CreateUpdateApiCategoryDto $dto
     * @return void
     */
    public function createOrUpdateCategory(Category $category, CreateUpdateApiCategoryDto $dto): void
    {
        $category->setName($dto->getName());
        $category->setSlug($this->slugger->slug(mb_strtolower($dto->getName())));

        $parentCategory = $this->repository->find($dto->getParentCategoryId());
        $category->setParent($parentCategory ?? null);

        $category->setPath($this->generateCategoryPath($category));

        $this->entityManager->persist($category);
        $this->entityManager->flush();
    }

    /**
     * @param Category $category
     * @return string|null
     */
    public function generateCategoryPath(Category $category): ?string
    {
        $parentCategory = $category->getParent();

        while ($parentCategory !== null){
            $categoryPath[] = $parentCategory->getId();
            $parentCategory = $parentCategory->getParent();
        }

        if (empty($categoryPath)) return null;

        $categoryPath = array_reverse($categoryPath);

        foreach ($category->getChildren() as $categoryChild) {

            $categoryChild->setPath($this->generateCategoryPath($categoryChild));

            $this->entityManager->persist($categoryChild);
        }

        return "/" . implode('/', $categoryPath) . "/";
    }

    /**
     * @param Category $category
     * @return Category[]
     */
    public function getAllCategoriesToParentCategory(Category $category): array
    {
        $qb = $this->entityManager->getRepository(Category::class)->createQueryBuilder('category');

        $nestedCategoriesIds = explode('/', $category->getPath());

        $qb->andWhere($qb->expr()->in('category.id', $nestedCategoriesIds));

        return $qb->getQuery()->getResult();
    }
}