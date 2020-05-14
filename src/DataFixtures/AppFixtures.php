<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('testUser@mail.ru');
        $password = $this->encoder->encodePassword($user, 'Aa12345');
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $user->setNameUser('User');
        $user->setAddresUser('Lipetsk');
        $user->setPhoneUser('+79008008090');

        $admin = new User();
        $admin->setEmail('testAdmin@mail.ru');
        $password = $this->encoder->encodePassword($admin, 'Aa12345');
        $admin->setPassword($password);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setNameUser('Admin');
        $admin->setAddresUser('Lipetsk');
        $admin->setPhoneUser('+78009009080');

        $manager->persist($user);
        $manager->persist($admin);

        $manager->flush();
    }
}
