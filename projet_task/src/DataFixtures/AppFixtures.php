<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use App\Entity\Util;
use App\Entity\Category;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //instance de la librairie faker
        $faker = Faker\Factory::create('fr_FR');
        //Variable pour stocker les utilisateurs
        $utils = [];
        //Variable pour stocker les categories
        $cats = [];
        //boucle pour ajouter 10 utilisateurs
        for ($i=0; $i < 10; $i++){
            $util =new Util();
            $util->setName($faker->lastName());
            $util->setFirstName($faker->firstName($gender = 'male'|'female'));
            $util->setMail($faker->freeEmail());
            $util->setPassword(password_hash($faker->word(), PASSWORD_DEFAULT));
            //on ajout les utilisateur au tableau
            $utils[]= $util;
            //stocker les objets
            $manager->persist($util);
        }
        //boucle pour ajouter 20 categories
        for ($i=0; $i < 20; $i++){
            $cat = new Category;
            $cat->setName($faker->jobTitle());
            //on ajout les categories au tableau
            $cats[]= $cat;
            //stocker les objets
            $manager->persist($cat);
        }
        //boucle pour ajouter 100 taches
        for ($i=0; $i < 100; $i++){
            $task = new Task();
            $task->setName($faker->jobTitle());
            $task->setContent($faker->text(40));
            $task->setDate($faker->datetime());
            $task->setCompleted($faker->boolean());
            $task->setUtil($utils[$faker->numberBetween(0,9)]);
            $task->addCategory($cats[$faker->numberBetween(0,9)]);
            $task->addCategory($cats[$faker->numberBetween(10,19)]);
            //stocker les objets
            $manager->persist($task);
        }
        $manager->flush();
    }
}
