<?php

namespace Nossis\NossisBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Nossis\NossisBundle\Entity\Stock;

class DevolucionControllerTest extends WebTestCase
{
    
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();
        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;
    }
    
    public function testIndex(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/devolucion/index');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Devolucion")')->count()
        );        
    }
    
    public function testNuevo(){
        $stocks = $this->em
            ->getRepository('NossisBundle:Stock')
            ->findAll();
        $stock = $stocks[1];
        $client = static::createClient();
        $crawler = $client->request('GET', '/devolucion/nuevo/' + $stock->getId());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Devolucion")')->count()
        );        
    }
    
    public function testMostrar(){
        $devoluciones = $this->em
            ->getRepository('NossisBundle:Devolucion')
            ->findAll();
        $devolucion = $devoluciones[0];
        $client = static::createClient();
        $crawler = $client->request('GET', '/devolucion/mostrar/' + $devolucion->getId());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Mostrar")')->count()
        );        
    }
    
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
    
}
