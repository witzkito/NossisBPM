<?php

namespace Nossis\NossisBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Nossis\NossisBundle\Entity\Stock;

class FraccionarControllerTest extends WebTestCase
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
        $stocks = $this->em
            ->getRepository('NossisBundle:Stock')
            ->findAll();
        $stock = $stocks[1];
        $client = static::createClient();
        $crawler = $client->request('GET', '/index');
        $form = $crawler->selectButton('Buscar')->form();
        $form['form[codigo]'] = $stock->getCodigo();
        
        $crawler = $client->submit($form);
        
        $link = $crawler->selectLink('Fraccionar')->link();
        
        $client->click($link);
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Stock ")')->count()
        );        
    }
    
    public function testShow(){
        $fraccionados = $this->em
            ->getRepository('NossisBundle:Fraccionar')
            ->findAll();
        $fraccion = $fraccionados[0];
        if ($fraccion != null){
           $client = static::createClient();
           $crawler = $client->request('GET', '/fraccionar/show/'. $fraccion->getId());
           $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Numero:")')->count()
            );
        }else{
            return true;
        }
    }
    
    public function testListar(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/fraccionar/listar/');
           $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Listar Fraccionados")')->count()
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
