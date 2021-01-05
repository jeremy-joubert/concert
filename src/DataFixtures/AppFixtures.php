<?php

namespace App\DataFixtures;

use App\Entity\Band;
use App\Entity\ConcertHall;
use App\Entity\Hall;
use App\Entity\Member;
use App\Entity\Show;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //creation salle
        for ($i=0;$i<10;$i++){
            $concertHall=new ConcertHall();
            $concertHall->setName($faker->company);
            $concertHall->setCity($faker->city);
            $concertHall->setPresentation($faker->paragraph);
            $manager->persist($concertHall);
            for ($j=0;$j<mt_rand(3,10);$j++){
                $hall=new Hall();
                $hall->setName($faker->company);
                $hall->setCapacity(mt_rand(100,10000));
                $hall->setAvailable(mt_rand(0,1));
                $hall->setConcertHall($concertHall);
                $manager->persist($hall);
                for ($l=0;$l<mt_rand(1,5);$l++){
                    $band=new Band();
                    $band->setName($faker->company);
                    $band->setLastalbumname($faker->company);
                    $band->setPicture('defautbrand.jpg');
                    $band->setStyle($faker->jobTitle);
                    $band->setYearofcreation($faker->dateTimeAD());
                    $manager->persist($band);
                    for ($k=0;$k<mt_rand(3,8);$k++){
                        $member=new Member();
                        $member->setName($faker->lastName);
                        $member->setFirstname($faker->firstName());
                        $member->setPicture('defaultmember.jpg');
                        $member->setBirthdate($faker->dateTimeAD());
                        $member->setJob($faker->jobTitle);
                        $member->setBand($band);
                        $manager->persist($member);
                    }
                    for ($k=0;$k<mt_rand(1,5);$k++){
                        $show=new Show();
                        $show->setDate($faker->dateTimeAD());
                        $show->setHall($hall);
                        $show->setBand($band);
                        $manager->persist($show);
                    }

                }
            }
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
