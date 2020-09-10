<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    public function getEntity():User
    {
        return (new User())
        ->setFirstName('Rosie')
        ->setLastName('Becher')
        ->setEmail('prohan@hotmail.com')
        ->setPicture('https://randomuser.me/api/portraits/women/55.jpg')
        ->setHash('password')
        ->setIntroduction('Tempore molestiae ducimus voluptatem eos fuga')
        ->setDescription('<p>Vel qui non quia voluptatem laborum accusamus quas. Ut dicta ducimus consequuntur.</p><p>Voluptas delectus aperiam dolor voluptatem et sed animi quasi. Dolorum ad optio qui quo hic. Atque corporis accusamus aliquid quas. Sed nemo et quasi aut.</p><p>Veritatis at rerum maxime voluptate quae sit repudiandae est. Ut facere cumque eveniet voluptatem molestiae. Quas nesciunt vero laboriosam nisi dolorum.</p>')
        ->setSlug('rosie-becker');

    }

    public function testValidEntity()
    {
        $user = $this->getEntity();
        self::bootKernel();
        $error =self::$container->get('validator')->validate($user);
        $this->assertCount(0,$error);
    }

    public function testInvalidUser(){
        $user = $this->getEntity()->setFirstName('');
        self::bootKernel();
        $error =self::$container->get('validator')->validate($user);
        $this->assertCount(1,$error);

    }
    public function testInvalidBlankUser(){
        $user = $this->getEntity()->setLastName('');
        self::bootKernel();
        $error =self::$container->get('validator')->validate($user);
        $this->assertCount(1,$error);
    }
    public function testInvalidEmail(){
        $user = $this->getEntity()->setEmail('janiya.homenick@spinka.biz');
        self::bootKernel();
        $error =self::$container->get('validator')->validate($user);
        $this->assertCount(0,$error);

    }

}
