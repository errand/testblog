<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Validator\Constraints\DateTime;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
	    $generator = Factory::create("et_EE");

	    for ($i = 0; $i < 100; $i++) {
		    $post = new Post();
		    $post->setTitle($generator->sentence);
		    $post->setDescription($generator->paragraphs(1, true));
		    $post->setBody($generator->paragraphs(15, true));
		    $post->setCreatedAtValue($generator->dateTime);
		    $post->setPrivate($generator->boolean());
		    $manager->persist($post);
	    }

        $manager->flush();
    }
}
