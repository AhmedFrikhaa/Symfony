<?php

namespace App\DataFixtures;

use App\Entity\Job;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class JobFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            "Data Science engenieer",
            "Dentist",
            "Registered Nurse",
            "Database Administrator",
            "Software Developer",
            "Veterinary Technologist & Technician",
            "Administrative Assistant",
            "Fabricator"
        ];
        for ($i=0;$i<count($data);$i++) {
            $job =new Job();
            $job->setDesignation($data[$i]);
            $manager->persist($job);
        }
        $manager->flush();
    }
}