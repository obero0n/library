<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Library;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Faker\Provider\Base;

class LibraryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++)
        {
            $library = new Library('Library');
            $library->setName($faker->company());
            $library->setCity($faker->city());
            $manager->persist($library);
        }
        $manager->flush();
        $this->addReference("Library", $library);
    }
}
