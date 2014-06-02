<?php

namespace Nossis\NossisBundle\Tests\Menu;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    
    public function testMenu()
    {
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Inicio")')->count());
    }
}
