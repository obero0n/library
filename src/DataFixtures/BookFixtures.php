<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Library;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Faker\Provider\Base;


use App\DataFixtures\UserFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class BookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 100; $i++)
        {
            $book = new Book();

            $book->setName($faker->company());
            $book->setStatus($faker->boolean());
            $book->setAutor($faker->name);
            $book->setResume($faker->text());
            $book->setDate($faker->dateTimeThisDecade($max = 'now', $timezone = null));
            $book->setCategory($this->getReference('Category'));
            $book->setUser($this->getReference('User'));
            $book->setLibrary($this->getReference('Library'));

            $manager->persist($book);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            LibraryFixtures::class,
            UserFixtures::class,
        );
    }
}
