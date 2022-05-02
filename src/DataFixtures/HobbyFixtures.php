<?php

namespace App\DataFixtures;

use App\Entity\Hobby;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HobbyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data=["basketball",
            "golf",
             "running",
             "walking",
             "soccer",
             "rugby",
            "weight lifting"
            ];
        for ($i=0;$i<count($data);$i++) {
            $hobby =new Hobby();
            $hobby->setDesignation($data[$i]);
            $manager->persist($hobby);
        }
        $manager->flush();
    }

}
