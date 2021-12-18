<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i <=10 ; $i++) { 
            $product = new Product();
            $product->setName("Product n° $i")
            ->setDescription("Description of product n° $i")
            ->setImage("http://placehold.it/350*150")
            ->setPrice($i*10+5);

            $manager->persist($product);
            }

        $manager->flush();
    }
}