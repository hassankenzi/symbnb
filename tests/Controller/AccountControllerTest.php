<?php

namespace App\Tests\Controller;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountControllerTest extends WebTestCase{
    
    public function testDisplayLogin(){
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testH1Login(){
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertSelectorTextContains('H1', 'connectez vous');

        }

        public function testDisplayLoginalert(){
            $client = static::createClient();
            $client->request('GET', '/login');
            $this->assertSelectorNotExists('alert.alert-danger'); 

        }

        public function testLoginWithBadCredentials(){
            $client = static::createClient();
            $crawler= $client->request(Request::METHOD_GET,'/login');
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
            
            $form = $crawler->filter("form[name=login]")->form([
                "login[email]"=> "janiya.homenick@spinka.biz",
                "login[password]" => 'password'
            ]) ;
            $client->submit($form);
            $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
            $client->followRedirect();
            $this->assertRouteSame('index');    
            }

        /**
         * Undocumented function
         *
         * @return Generator
         */
        public function provideFailed()
        {
            yield[
                [
               
                    "login[email]"=> "fail",
                    "login[password]" => 'password'
                ], 'les information incorecte'
            ];
            yield[
                [

                
                    "login[email]"=> "janiya.homenick@spinka.biz",
                    "login[password]" => 'fail'
                ], 'les information incorecte'
            ];
        }


        // public function testLoginWithBadCredentials(){
        //     $client = static::createClient();
        //     $crawler = $client->request('GET', '/login');
        //     $form = $crawler->selectButton('Connexion')->form([
        //         'email'=> 'snader@oberbrunner.com',
        //         'password' => 'password'
        //     ]);
        //     $client->submit($form);
        //     $this->assertResponseRedirects('/login');
        //     $client->followRedirect();
        //     $this->assertSelectorExists('alert.alert-danger');
        // }
        // public function testSuccessFullLogin(){
        //     $client = static::createClient();

        //     $csrfToken = $client->getContainer()->get('security.csrf.token_manager')->getToken('$csrfTokenId');

        //     $client->request('POST', '/login',[
        //         'csfr_token' => $csrfToken,
        //        'email'=> 'snader@oberbrunner.com',
        //         'password' => 'password'
        //     ]);

        //     $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        // }

    
}