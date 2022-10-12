<?php

namespace App\Infrastructure\AbstractClass;

use App\Response\Collection\EntityArrayCollection;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

abstract class BaseAbstractRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @param array|null $context
     * @return array
     */
    public function findPublishedEntities(?array $context = []): array
    {
        $qb = $this->createQueryBuilder('entity');

        $qb->andWhere('entity.publish = 1');

        if (array_key_exists('count', $context)){
            $qb->setMaxResults($context['count']);
        }

        if (array_key_exists('popular', $context)){
            $qb->andWhere('entity.popular = 1');
        }

        if (array_key_exists('best', $context)){
            $qb->andWhere('entity.best = 1');
        }

        if (array_key_exists('slider', $context)){
            $qb->andWhere('entity.slider = 1');
        }

        if (array_key_exists('now', $context)){

            $date = new DateTime();

            $qb->andWhere('entity.date >= :dateFrom');

            $qb->setParameter('dateFrom', $date->format('Y-m-d'));
        }

        if (array_key_exists('exclude_route', $context)){
            $route = explode('/', $context['exclude_route'])[1];
            $qb->andWhere('entity.url NOT LIKE :exclude_route');
            $qb->setParameter('exclude_route', "%$route%");

        }
        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $searchString
     * @param array $context
     * @return EntityArrayCollection
     */
    public function search(string $searchString, array $context = []): EntityArrayCollection
    {
        $qb = $this->createQueryBuilder('entity');

        if (array_key_exists('publish', $context)) {
            if ($context['publish']){
                $qb->andWhere("entity.publish = ${context['publish']}");
            }
        }
        else{
            $qb->andWhere("entity.publish = 1");
        }

        if (array_key_exists('exclude_ids', $context) && array_key_exists('exclude_name', $context)) {

            $qb->andWhere($qb->expr()->notIn("entity.${context['exclude_name']}", ':ids'));

            $qb->setParameter('ids', explode('-', $context['exclude_ids']));
        }

        $qb->andWhere('entity.name LIKE :searchString');

        $qb->setParameter('searchString', "%$searchString%");

        return new EntityArrayCollection($qb->getQuery()->getResult());
    }
}
