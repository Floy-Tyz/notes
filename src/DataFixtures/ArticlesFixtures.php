<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Service\SimplyGenerator\SimplyGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticlesFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var int NUMBER_OF_ENTITIES */
    const NUMBER_OF_ENTITIES = 10;

    /**
     * @param SimplyGenerator $generator
     * @param SluggerInterface $slugger
     */
    public function __construct(
        private readonly SimplyGenerator $generator,
        private readonly SluggerInterface $slugger,
    ){}

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $categoryCount = count($manager->getRepository(Category::class)->findAll());
        for ($i = 1; $i <= $categoryCount; $i++){

            /** @var Category $category */
            $category = $manager->getRepository(Category::class)->find($i);

            for ($j = 1; $j <= self::NUMBER_OF_ENTITIES; $j++) {

                $article = new Article();

                $name = $this->generator->text();
                $article->setName($name);
                $article->setSlug(strtolower($this->slugger->slug($name)));
                $article->setContent($this->generator->text(300));

                $article->setCategory($category);

                $manager->persist($article);

            }
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return[
            CategoryFixtures::class
        ];
    }
}
