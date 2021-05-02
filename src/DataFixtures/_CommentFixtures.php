<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Validator\Constraints\DateTime;
use App\DataFixtures\PostFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
	    $generator = Factory::create("et_EE");

	    for ($i = 0; $i < 1000; $i++) {
		    $comment = new Comment();
		    $comment->setAuthor($generator->name);
		    $comment->setText($generator->paragraphs(1, true));
		    $comment->setEmail($generator->email);
		    $comment->setCreatedAtValue($generator->dateTime);
		    //$comment->setPost($generator->numberBetween(1, 100));
		    $comment->setPost($this->getReference(PostFixtures::POST_REFERENCE));


		    $manager->persist($comment);

	    }

        $manager->flush();
    }

		public function getDependencies()
		{
			return [PostFixtures::class];
		}
}
