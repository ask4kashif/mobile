<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;


class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
       
            $product = new Product();
			$product->setName('Galaxy Edge S6');
            $product->setDescription('New Mobile');   
            
            $product->setCategory(  
                $this->getReference('category.samsung')
            );
            
            $product->setType(  
                $this->getReference('type.mobile')
            );
            
            $manager->persist($product);
            $manager->flush();
    }
    public function getOrder()
    {
    	return 100;
    }
}