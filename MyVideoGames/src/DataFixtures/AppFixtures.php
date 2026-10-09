<?php

namespace App\DataFixtures;

use App\Entity\Bibliotheque;
use App\Entity\Jeu;
use App\Entity\Membre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private const RETRO_BIBLIO = 'retro-bibliotheque';
    private const MA_BIBLIO = 'ma-bibliotheque';
    
    /**
     * Generates initialization data for bibliotheques : [membre reference, nom, bibliotheque reference]
     *
     * @return \Generator
     */
    private static function bibliothequeDataGenerator()
    {
        yield [ UserFixtures::MOI, "Ma ludothèque personnelle",      self::MA_BIBLIO    ];
        yield [ UserFixtures::SLASH,   "Collection Rétro & Classiques", self::RETRO_BIBLIO ];
    }
    
    /**
     * Generates initialization data for jeux :
     * [bibliotheque reference, nom, annee]
     *
     * @return \Generator
     */
    private static function jeuxGenerator()
    {
        yield [ self::MA_BIBLIO,    "The Witcher 3: Wild Hunt",              2015 ];
        yield [ self::MA_BIBLIO,    "Elden Ring",                            2022 ];
        yield [ self::RETRO_BIBLIO, "The Legend of Zelda: Ocarina of Time",  1998 ];
    }
    
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
    
    public function load(ObjectManager $manager): void
    {
        foreach (self::bibliothequeDataGenerator() as [ $membreReference, $nom, $bibliothequeReference ]) {
            $membre = $this->getReference($membreReference, Membre::class);
            
            $bibliotheque = new Bibliotheque();
            $bibliotheque->setNom($nom);
            $bibliotheque->setMembre($membre);
            
            $manager->persist($bibliotheque);
            $manager->flush();
            
            $this->addReference($bibliothequeReference, $bibliotheque);
        }
        
        foreach (self::jeuxGenerator() as [ $bibliothequeReference, $nom, $annee ]) {
            $bibliotheque = $this->getReference($bibliothequeReference, Bibliotheque::class);
            
            $jeu = new Jeu();
            $jeu->setNom($nom);
            $jeu->setAnnee($annee);
            
            $bibliotheque->addJeu($jeu);
            
            $manager->persist($bibliotheque);
        }
        $manager->flush();
    }
}