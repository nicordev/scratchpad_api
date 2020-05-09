<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->loadUsers($manager);
        $notes = $this->loadNotes($manager);
        $noteCount = count($notes);

        for ($i = 0; $i < ($noteCount / 2); $i++) {
            $this->linkUserToNote($users[0], $notes[$i]);
        }

        for (; $i < $noteCount; $i++) {
            $this->linkUserToNote($users[1], $notes[$i]);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        $jim = new User();
        $jim->setEmail('jim.nastique@gmail.com')
            ->setFirstName('jim')
            ->setLastName('nastique')
            ->setNickName('jimnaz')
            ->setPassword($this->encoder->encodePassword($jim, 'pwdSucks!0'))
        ;
        $manager->persist($jim);

        $sarah = new User();
        $sarah->setEmail('sarah.croche@gmail.com')
            ->setFirstName('sarah')
            ->setLastName('croche')
            ->setNickName('saharache')
            ->setPassword($this->encoder->encodePassword($jim, 'pwdSucks!0'))
        ;

        $manager->persist($sarah);

        return [$jim, $sarah];
    }

    private function loadNotes(ObjectManager $manager)
    {
        $notes = [];

        for ($i = 0; $i < 10; $i++) {
            $note = new Note();
            $note->setTitle("Dummy note {$i}");
            $note->setContent("Dummy note content {$i}");
            $notes[] = $note;
            $manager->persist($note);
        }

        return $notes;
    }

    private function linkUserToNote(User $user, Note $note)
    {
        $user->addNote($note);
        $note->addUser($user);
    }
}
