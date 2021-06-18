<?php

namespace App\DataFixtures;

use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

       QuestionFactory::new()->createMany(20);
        QuestionFactory::new()
            ->unpublished()
            ->createMany(5);
       $manager->flush();
    }
}
