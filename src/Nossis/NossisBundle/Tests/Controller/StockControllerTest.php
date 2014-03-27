<?php

namespace Nossis\NossisBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StockControllerTest extends WebTestCase
{
    public function testIngresar()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/stock/ingresar');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Ingresar Stock")')->count()
        );
        
    }
    
    public function testFormIngresar(){
        $client = static::createClient();
        $crawlerForm = $client->request('GET', '/stock/ingresar');
        $this->assertEquals('Nossis\NossisBundle\Controller\StockController::ingresarAction', $client->getRequest()->attributes->get('_controller'));
        
        $form = $crawlerForm->selectButton('Ingresar')->form();
        
        $form['nossis_nossisbundle_stock[producto]']->select('2');
        $form['nossis_nossisbundle_stock[lote]'] = 'lote';
        $form['nossis_nossisbundle_stock[fechaEnvasado]'] = '2014-03-27';
        $form['nossis_nossisbundle_stock[palet]'] = 'palet';
        $form['nossis_nossisbundle_stock[turno]']->select('A');
        $form['nossis_nossisbundle_stock[cantidad]'] = '40';
        $form['nossis_nossisbundle_stock[area]']->select('2');
        
        
        $crawler = $client->submit($form);
        
        $this->assertEquals('Nossis\NossisBundle\Controller\StockController::agregarAction', $client->getRequest()->attributes->get('_controller'));
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("El stock fue ingresado correctamente!!")')->count()
        );
        
    }

}
