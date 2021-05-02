<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminFixtures extends Fixture
{
		private $encoder;

		public function __construct(UserPasswordEncoderInterface $encoder)
		{
			$this->encoder = $encoder;
		}

    public function load(ObjectManager $manager)
    {

		    $admin = new Admin();
		    $admin->setUsername('admin');
	      $password = $this->encoder->encodePassword($admin, '123');
	      $admin->setPassword($password);
		    $admin->setRoles(array('ROLE_ADMIN'));
		    $manager->persist($admin);

        $manager->flush();
    }
}
