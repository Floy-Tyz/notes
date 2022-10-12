<?php

namespace App\Infrastructure\Utils;

use App\Infrastructure\Http\Request\RequestDataInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\Exception\NoSuchPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class DataTransformer
{
    private static PropertyAccessorInterface|null $propertyAccessor = null;

    /**
     * @param EntityManagerInterface $entityManager
     * @param object $entity
     * @param \App\Infrastructure\Http\Request\RequestDataInterface $data
     * @return void
     */
    public static function transform(EntityManagerInterface $entityManager, object $entity, RequestDataInterface $data): void
    {
        $entityColumns = $entityManager->getClassMetadata($entity::class)->getColumnNames();

        $propertyAccessor = self::createPropertyAccessor();

        foreach ($entityColumns as $column){

            try {
                if ($propertyAccessor->isReadable($data, $column)){
                    $propertyAccessor->setValue($entity, $column, $propertyAccessor->getValue($data, $column));
                }
            }
            catch (NoSuchPropertyException $exception){
            }
        }
    }

    /**
     * @return PropertyAccessorInterface
     */
    private static function createPropertyAccessor(): PropertyAccessorInterface
    {
        if (!self::$propertyAccessor){
            return self::$propertyAccessor = PropertyAccess::createPropertyAccessor();
        }

        return self::$propertyAccessor;
    }
}