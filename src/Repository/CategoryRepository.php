<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return Category[]
     */
    public function getParentCategories(): array
    {
        $qb = $this->createQueryBuilder('category');

        $qb->andWhere("category.parent IS NULL");

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Category $category
     * @return Category[]
     */
    public function getAllChildren(Category $category): array
    {
        $qb = $this->createQueryBuilder('category');

        $qb->andWhere("category.path LIKE :path ESCAPE '!'");

        $qb->setParameter('path', '%!/' . addcslashes($category->getId(), '%_') . '!/%');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Category $category
     * @return array
     */
    public function getPath(Category $category): array
    {
        $qb = $this->createQueryBuilder('category');

        $path = $category->getPath();

        $path = explode('/', $path);

        $qb->andWhere( $qb->expr()->in('category.id', $path) );

        $categories = $qb->getQuery()->getResult();

        $result = [];

        foreach ($path as $id) {

            foreach ($categories as $categoryPath) {

                if ($categoryPath->getId() == $id) $result[] = $categoryPath;
            }
        }

        $result[] = $category;

        return $result;
    }
}
