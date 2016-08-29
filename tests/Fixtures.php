<?php
namespace Test;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use app\Entity\Department;

class Fixtures implements FixtureInterface
{
    /**
     * Load the Post fixtures
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        $dept = new Department();
        $manager->persist($dept);
        $manager->flush();
    }
}
