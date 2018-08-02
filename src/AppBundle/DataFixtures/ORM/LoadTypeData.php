<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Type;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;


class LoadTypeData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
       
            $type = new Type();
			$type->setName('Mobile');

            $this->addReference('type.mobile', $type);     
            $manager->persist($type);
            $manager->flush();
    }
    public function getOrder()
    {
    	return 20;
    }
}