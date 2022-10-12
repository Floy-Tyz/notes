<?php

namespace App\DataFixtures;

use App\Model\Note\Orm\Entity\Note;
use App\Service\SimplyGenerator\SimplyGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class NoteFixtures extends Fixture
{
    /** @var int */
    const NUMBER_ENTITIES = 3;

    /**
     * @param SluggerInterface $slugger
     * @param SimplyGenerator $generator
     */
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly SimplyGenerator $generator
    ){}

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::NUMBER_ENTITIES; $i++){

            $note = new Note();

            $name = $this->generator->text(15);
            $note->setName($name);
            $note->setSlug(strtolower($this->slugger->slug($name)));

            $manager->persist($note);
        }

        $manager->flush();
    }
}
