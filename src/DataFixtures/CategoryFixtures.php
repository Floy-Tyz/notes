<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Service\Category\CategoryService;
use App\Service\SimplyGenerator\SimplyGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    /** @var int NUMBER_OF_PARENT_ENTITIES */
    const NUMBER_OF_PARENT_ENTITIES = 3;

    /** @var int NUMBER_OF_NESTS */
    const NUMBER_OF_NESTS = 3;

    /** @var int NUMBER_OF_NESTED_ENTITIES */
    const NUMBER_OF_NESTED_ENTITIES = 3;

    /**
     * @param SluggerInterface $slugger
     * @param CategoryService $categoryService
     * @param SimplyGenerator $generator
     */
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly CategoryService $categoryService,
        private readonly SimplyGenerator $generator
    ){}

    /**
     * @param ObjectManager $manager
     * @throws ContainerExceptionInterface
     * @throws ExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::NUMBER_OF_PARENT_ENTITIES; $i++){

            $parentCategory = $this->generateBaseCategory($manager);
            $parentCategory->setPath($this->categoryService->generateCategoryPath($parentCategory));
            $manager->flush();

            $this->generateNestedCategory($manager, $parentCategory);
        }
    }

    /**
     * @param ObjectManager $manager
     * @param Category $parentCategory
     * @param int $nest
     * @return void
     * @throws ContainerExceptionInterface
     * @throws ExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function generateNestedCategory(ObjectManager $manager, Category $parentCategory, int $nest = 0): void
    {
        if ($nest === self::NUMBER_OF_NESTS) return;

        for ($i = 0; $i < self::NUMBER_OF_NESTED_ENTITIES; $i++) {

            $category = $this->generateBaseCategory($manager);
            $category->setParent($parentCategory);
            $category->setPath($this->categoryService->generateCategoryPath($category));
            $manager->flush();

            $this->generateNestedCategory($manager, $category, $nest + 1);
        }
    }

    /**
     * @param ObjectManager $manager
     * @return Category
     */
    private function generateBaseCategory(ObjectManager $manager): Category
    {
        $category = new Category();

        $name = $this->generator->text(15);
        $category->setName($name);
        $category->setSlug(strtolower($this->slugger->slug($name)));
        $category->setPopular(true);
        $category->setDescription($this->generator->text(100));

        $manager->persist($category);
        $manager->flush();

        return $category;
    }
}
