<?php


namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public const TYPE_LIST = [
        "Activité Sportive",
        "Compétiton",
        "Compétition amateur",
        "Championat",
        "Tournoi",
        "Journée découverte",
        "Journée associative",
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::TYPE_LIST as $id => $aType):
            $typeElement = new Type();
            $typeElement
                ->setNom($aType)
                ->setColor('#' . CategorieFixtures::randHexa())
            ;

            $manager->persist($typeElement);

            $this->addReference('type' . $id, $typeElement);
        endforeach;

        $defaultType = new Type();
        $defaultType
            ->setNom('Autre')
            ->setColor('#' . CategorieFixtures::randHexa())
        ;

        $manager->persist($defaultType);
        $manager->flush();
    }
}