<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AdControllerTest extends WebTestCase{
    public function testAdsPage(){
        $client = static::createClient();
        $client->request('GET', '/ads');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testH1PPage(){
        $client = static::createClient();
        $client->request('GET', '/ads');
        $this->assertSelectorTextContains('H1', 'Voici les annonces de nos hotes !');

    }
    // public function testAuthPageIsRestricted(){
    //     $client = static::createClient();
    //     $client->request('GET', '/login');
    //     $this->assertResponseRedirects('/index') ;
    // }

}