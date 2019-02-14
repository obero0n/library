<?php

namespace App\DataFixtures;
use App\Entity\Librarian;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;
use Faker\Provider\Base;



class LibrarianFixtures extends Fixture
{

  private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
      {
         $this->passwordEncoder = $passwordEncoder;
      }


    public function load(ObjectManager $manager)
    {
      $faker = Faker\Factory::create('fr_FR');
      $librarian = new librarian();

        $librarian->setRoles(array('ROLE_ADMIN'));
        $librarian->setUsername($faker->name);
        $librarian->setPassword($this->passwordEncoder->encodePassword(
             $librarian,
             'test'
         ));

        $manager->persist($librarian);


        $manager->flush();
    }
}
