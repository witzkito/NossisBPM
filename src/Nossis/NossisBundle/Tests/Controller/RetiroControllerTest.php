<?php

namespace Nossis\NossisBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RetiroControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'despachar/index');
        
         $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Despachar")')->count()
        );
    }
    
    public function testNew()
    {
        $client = static::createClient();
        $crawlerForm = $client->request('GET', 'despachar/index');
        $form = $crawlerForm->selectButton('Guardar')->form();
        
        $form['nossis_nossisbundle_retiro[cliente]']->select('3');
        $form['nossis_nossisbundle_retiro[nroOrden]'] = '99';
        $form['nossis_nossisbundle_retiro[patente]'] = 'ZZZ999';
        $form['nossis_nossisbundle_retiro[empresa]']->select('5');
        $form['nossis_nossisbundle_retiro[transportista]']= 'Juan Perez';
        
        $crawler = $client->submit($form);
        
        $this->assertEquals('Nossis\NossisBundle\Controller\RetiroController::newAction', $client->getRequest()->attributes->get('_controller'));
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Despachar")')->count()
        );
        
        $form = $crawler->selectButton('Guardar')->form();
        $crawler = $client->submit($form);
        
        $this->assertEquals('Nossis\NossisBundle\Controller\RetiroController::editAction', $client->getRequest()->attributes->get('_controller'));
        
        
    }
    
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
    
    public function testListar()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'despachar/listar');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('tr.grid-row-titles')->count()
        );
    }

}
