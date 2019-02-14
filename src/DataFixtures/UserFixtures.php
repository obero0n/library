<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Faker\Provider\Base;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++)
        {
            $user = new User();
            $user->setFirstname($faker->name);
            $user->setLastname($faker->name);
            $user->setCode($faker->randomNumber($nbDigits = NULL, $strict = false));
            $user->setLibrary($this->getReference('Library'));
            $manager->persist($user);
        }
        $manager->flush();
        $this->addReference("User", $user);
    }
}
