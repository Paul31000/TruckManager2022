<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    public function testMapPage(){
        $client= static::createClient();
        $crawler=$client->request('GET','/map');
        $this->assertResponseIsSuccessful();
    }

}
