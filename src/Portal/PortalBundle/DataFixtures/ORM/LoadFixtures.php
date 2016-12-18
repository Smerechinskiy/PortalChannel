<?php
/**
 * Created by PhpStorm.
 * User: Богдан
 * Date: 19.05.2016
 * Time: 21:44
 */

namespace Portal\PortalBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Portal\PortalBundle\Entity\User;
use Portal\PortalBundle\Entity\Channel;

class LoadFixtures extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadChanel($manager);
    }

    public function loadUser($manager)
    {
        $user = new User();
        $user->setUsername('Admin');
        $user->setPlainPassword('admin');
        $user->setEnabled(true);
        $user->setEmail('admin@gmail.com');
        $manager->persist($user);
        $this->setReference('one_user', $user);

        $user = new User();
        $user->setUsername('Test');
        $user->setPlainPassword('test');
        $user->setEnabled(true);
        $user->setEmail('test@gmail.com');
        $manager->persist($user);
        $this->setReference('two_user', $user);

        $manager->flush();
    }

    public function loadChanel($manager)
    {
        $channel = new Channel();
        $channel->setName('Быстрый старт с PHP 7');
        $channel->setDescription('Краткий рассказ о выходе PHP 7 и ознакомительном видео-курсе.');
        $channel->setUser($this->getReference('one_user'));
        $manager->persist($channel);

        $channel = new Channel();
        $channel->setName('Видео-курс по JavaScript');
        $channel->setDescription('Представляю вам свой курс по JavaScript, недавно прошедний на Хекслете. Курс состоит из семи лекций общей продолжительностью около четырех часов. ');
        $channel->setUser($this->getReference('one_user'));
        $manager->persist($channel);

        $channel = new Channel();
        $channel->setName('Изучение Symfony2');
        $channel->setDescription('Первый урок серии видеоуроков по Symfony2. Начальный уровень. ');
        $channel->setUser($this->getReference('two_user'));
        $manager->persist($channel);

        $channel = new Channel();
        $channel->setName('Python 3 для начинающих');
        $channel->setDescription('Обучение программированию на языке Python. С самого начала.');
        $channel->setUser($this->getReference('two_user'));
        $manager->persist($channel);

        $manager->flush();
    }
}