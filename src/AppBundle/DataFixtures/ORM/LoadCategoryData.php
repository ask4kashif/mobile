<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;


class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
       
            $category = new Category();
			$category->setName('Samsung');
            $this->addReference('category.samsung',$category);     
            $manager->persist($category);
            $manager->flush();
    }
    public function getOrder()
    {
    	return 40;
    }
}