<?php

namespace App\Tests\Entity;

use App\Entity\Ad;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdTest extends KernelTestCase{

    public function getEntity(){
        
        return (new Ad())
        ->setTitle('Sed omnis omnis voluptatibus ratione esse sed dolorem non')
        ->setSlug('sed-omnis-omnis-voluptatibus-ratione-esse-sed-dolorem-non')
        ->setPrice('161')
        ->setIntroduction('Officia qui ipsum expedita molestiae. Dolorem volu...')
        ->setContent('<p>At consequatur error et voluptas est sunt laboriosam. Odio temporibus omnis architecto quo aut suscipit. Explicabo nemo commodi est.</p><p>Voluptate itaque omnis velit impedit vitae. Sint temporibus facere eligendi qui. Qui veniam quis et aut unde. Possimus beatae harum error iste non et.</p><p>Quia provident voluptatem ut recusandae consequuntur. Necessitatibus nihil velit itaque ea minima maiores. Distinctio cumque ipsa adipisci hic neque. Quis animi vitae nulla officiis aut animi sunt.</p><p>Quasi qui suscipit quasi dolores. Delectus quisquam sit maxime officiis autem. Accusamus soluta velit quas velit. Ipsum error sequi ad suscipit consequuntur iusto ipsa.</p><p>Blanditiis rerum repellendus sint animi ratione quos. Voluptas eligendi qui sunt eveniet magni. Est eos exercitationem beatae eius similique libero repudiandae. Repudiandae rerum distinctio quidem modi ea corrupti dolor.</p>')
        ->setCoverImage('https://lorempixel.com/1000/350/?61205')
        ->setPostalCode('69008')
        ->setRooms('1');
    }
    public function testValidEntity()
    {
        $ad = $this->getEntity();
        self::bootKernel();
        $error =self::$container->get('validator')->validate($ad);
        $this->assertCount(0,$error);
    }
    public function testIvalidEntity()
    {
        $ad = $this->getEntity()->setSlug('');
        self::bootKernel();
        $error =self::$container->get('validator')->validate($ad);
        $this->assertCount(1,$error);
    }
    
    

}