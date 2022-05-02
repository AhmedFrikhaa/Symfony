<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtires extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $profile=new Profile() ;
       $profile->setRs("Facebook");
       $profile->setUrl("https://www.facebook.com/ahmed.frikha.395/");
        $profile2=new Profile() ;
        $profile3=new Profile() ;
        $profile2->setRs("instagram");
        $profile2->setUrl("https://www.instagram.com/ahmedfrikhaa/?hl=fr");
        $profile3->setRs("Twitter");
        $profile3->setUrl("https://twitter.com/AhmedFrikhaa");
        $manager->persist($profile);
        $manager->persist($profile3);
        $manager->persist($profile2);
        $manager->flush();
    }
}
