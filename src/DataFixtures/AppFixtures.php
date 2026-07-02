<?php

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            ['Jean', 'Dupont', 'MAT001'],
            ['Marie', 'Martin', 'MAT002'],
            ['Pierre', 'Bernard', 'MAT003'],
        ];

        foreach ($data as [$firstName, $lastName, $matricule]) {
            $user = new User();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setMatricule($matricule);
            $manager->persist($user);
        }

        $chantiers = [
            ['Chantier A', '12 rue de la Paix, Marseille', '2026-01-01', '2026-06-30'],
            ['Chantier B', '5 avenue du Port, Marseille', '2026-02-01', '2026-08-31'],
        ];

        foreach ($chantiers as [$name, $address, $start, $end]) {
            $project = new Project();
            $project->setName($name);
            $project->setAddress($address);
            $project->setDateStart(new \DateTime($start));
            $project->setDateEnd(new \DateTime($end));
            $manager->persist($project);
        }

        $manager->flush();
    }
}