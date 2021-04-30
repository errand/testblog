<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\DateTime;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

		    $admin = new Admin();
		    $admin->setUsername('admin');
		    $admin->setPassword('$argon2id$v=19$m=65536,t=4,p=1$5xx60DC+TK+jS6XgBGr75A$3jPgt81wMt/2pjXpPcKs/5vtYqPfmr4kiMLMJt3cf/0');
		    $admin->setRoles(array('ROLE_ADMIN'));
		    $manager->persist($admin);

        $manager->flush();
    }
}
