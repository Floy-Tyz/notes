<?php

namespace App\Infrastructure\AbstractClass;

use App\Service\File\FileService;
use App\Service\SimplyGenerator\SimplyGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

abstract class BaseAbstractFixture extends Fixture
{
    /**
     * @param SimplyGenerator $generator
     * @param FileService $fileService
     * @param SluggerInterface $slugger
     */
    public function __construct(
        protected readonly SimplyGenerator  $generator,
        protected readonly FileService      $fileService,
        protected readonly SluggerInterface $slugger
    ){}
}
