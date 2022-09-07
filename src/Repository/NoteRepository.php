<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * @return Note[]
     */
    public function getParentCategories(): array
    {
        $qb = $this->createQueryBuilder('category');

        $qb->andWhere("category.parent IS NULL");

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Note $category
     * @return Note[]
     */
    public function getAllChildren(Note $category): array
    {
        $qb = $this->createQueryBuilder('category');

        $qb->andWhere("category.path LIKE :path ESCAPE '!'");

        $qb->setParameter('path', '%!/' . addcslashes($category->getId(), '%_') . '!/%');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param Note $category
     * @return array
     */
    public function getPath(Note $category): array
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
