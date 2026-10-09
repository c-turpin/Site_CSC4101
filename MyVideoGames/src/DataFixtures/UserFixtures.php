<?php

namespace App\DataFixtures;

use App\Entity\Membre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const SLASH = 'slash';
    public const MOI = 'moi';
    
    private UserPasswordHasherInterface $hasher;
    
    /**
     * Generates initialization data for membres :
     *  [email, plain text password, membre reference]
     * @return \Generator
     */
    private static function membresGenerator()
    {
        yield ['moi@localhost', '123456', self::MOI];
        yield ['slash@localhost', '123456', self::SLASH];
    }
    
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        foreach (self::membresGenerator() as [$email, $plainPassword, $membreReference]) {
            $user = new Membre();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);
            
            $manager->persist($user);
            $manager->flush();
            $this->addReference($membreReference, $user);
        }
    }
}