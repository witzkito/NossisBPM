<?php

namespace Nossis\NossisBundle\Tests\Controller;

use Nossis\NossisBundle\Entity\Almacen;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    
    public function testIndex()
    {
        
        $client = static::createClient();

        $crawler = $client->request('GET', '/index');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Codigo")')->count()
        );
    }
}
