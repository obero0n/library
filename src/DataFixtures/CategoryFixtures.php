<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Faker\Provider\Base;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++)
        {
            $category = new Category();
            $category->setCategoryName($faker->name);

            $manager->persist($category);
            $manager->flush();
        }
        $this->addReference("Category", $category);
    }
}
