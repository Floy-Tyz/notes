<?php

namespace App\Service\SimplyGenerator;

use Faker\Factory;
use Faker\Generator;

class SimplyGenerator
{
    /** @var Generator $faker */
    public Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function text(int $length = 10): string
    {
        return str_replace('.','', $this->faker->text($length));
    }

}