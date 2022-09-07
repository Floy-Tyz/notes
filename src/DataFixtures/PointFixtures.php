<?php

namespace App\DataFixtures;

use App\Entity\Point;
use App\Entity\Note;
use App\Service\SimplyGenerator\SimplyGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class PointFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var int NUMBER_OF_ENTITIES */
    const NUMBER_OF_ENTITIES = 5;

    /**
     * @param SimplyGenerator $generator
     */
    public function __construct(
        private readonly SimplyGenerator $generator,
    ){}

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $noteCount = count($manager->getRepository(Note::class)->findAll());

        for ($i = 1; $i <= $noteCount; $i++){

            /** @var Note $note */
            $note = $manager->getRepository(Note::class)->find($i);

            for ($j = 1; $j <= self::NUMBER_OF_ENTITIES; $j++) {

                $article = new Point();

                $name = $this->generator->text();
                $article->setName($name);
                $article->setChecked($this->generator->faker->boolean);

                $article->setNote($note);

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
            NoteFixtures::class
        ];
    }
}
