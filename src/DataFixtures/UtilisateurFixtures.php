<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurFixtures extends Fixture implements DependentFixtureInterface
{
    public const USER_LIST = 25;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $j = 0;
        $password = "'Azerty123&@.";

        for ($i = 1; $i <= self::USER_LIST; $i++) {
            $j = $j < sizeof(CategorieFixtures::CATEG_LIST) - 1 ? $j + 1 : $j = 0;
            $user = new User();
            $user
                ->setEmail('eleve' . $i . '@gmail.com')
                ->setNom('NomEleve' . $i)
                ->setPrenom('PrenomEleve' . $i)
                ->setRoles('ROLE_USER')
                ->setCreer(new DateTime('now'))
                ->setNaissance(new DateTime('now'))
                ->setModifier(new DateTime('now'))
                ->setPassword($this->encoder->encodePassword($user, $password))
                ->setForgottenPassword(false);

            /** @var Categorie $uneCateg */
            $uneCateg = $this->getReference("categ$j");

            $user->setCategorie($uneCateg);
            $manager->persist($user);
            $this->addReference('eleve' . $i, $user);
        }
        $admin = new User();
        $admin
            ->setEmail('admin@gmail.com')
            ->setNom('adminNom')
            ->setPrenom('adminPrenom')
            ->setRoles('ROLE_ADMIN')
            ->setCreer(new DateTime('now'))
            ->setNaissance(new DateTime('now'))
            ->setModifier(new DateTime('now'))
            ->setPassword($this->encoder->encodePassword($admin, $password))
            ->setForgottenPassword(false);
        /** @var Categorie $uneCateg */
        $uneCateg = $this->getReference("categ" . rand(0, 3));
        $admin->setCategorie($uneCateg);
        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class,
        ];
    }
}