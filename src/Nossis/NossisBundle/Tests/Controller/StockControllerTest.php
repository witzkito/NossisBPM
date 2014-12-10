<?php

namespace Nossis\NossisBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Nossis\NossisBundle\Entity\Stock;

class StockControllerTest extends WebTestCase
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
            $form['nossis_nossisbundle_stock[ingresado]'] = '40';
            $form['nossis_nossisbundle_stock[area]']->select('2');


            $crawler = $client->submit($form);
        
        $this->assertEquals('Nossis\NossisBundle\Controller\StockController::agregarAction', $client->getRequest()->attributes->get('_controller'));
        
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('tr.datagrid-agregado')->count()
        );
        
    }
    
    public function testIndex(){
        $client = static::createClient();
        $crawler = $client->request('GET', '/index');
        
        $form = $crawler->selectButton('Buscar')->form();
        $form['form[codigo]'] = "1";
        
        $crawler = $client->submit($form);
        
        $crawler = $client->followRedirect();
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Codigo")')->count()
        );

        //var_dump($client->getResponse()->getContent());
        
        $stocks = $this->em
            ->getRepository('NossisBundle:Stock')
            ->findAll();
        
        $stock = $stocks[1];
        
        $form = $crawler->selectButton('Buscar')->form();
        $form['form[codigo]'] = $stock->getCodigo();
        
        $crawler = $client->submit($form);
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("'."Stock ". $stock->getId() .'")')->count()
        );
       
    }
    
    public function testActualizarStock()
    {
        $stock = new Stock;
        $stock->setActual(100);
        $stock->actualizarStock(0, 40);        
        $this->assertEquals(60, $stock->getActual());
    }
    
    public function testListarIngreso()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/stock/listar/ingreso');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Listar Ingresos")')->count()
        );
        
    }
    
    public function testEditar()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/stock/listar/ingreso');
        $link = $crawler->selectLink('Editar')->link();
        $client->click($link);
        $this->assertEquals('Nossis\NossisBundle\Controller\StockController::editarAction', $client->getRequest()->attributes->get('_controller'));
        $crawler = $client->getCrawler();
        $form = $crawler->selectButton('Guardar')->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        var_dump($client->getResponse()->getContent());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("| Stock ")')->count()
        );
    }
    
    public function testImprimir()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/stock/listar/ingreso');
        $link = $crawler->selectLink('Imprimir')->link();
        $client->click($link);
        $this->assertEquals('Nossis\NossisBundle\Controller\StockController::imprimirAction', $client->getRequest()->attributes->get('_controller'));       
    }
    

    public function testListar()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/stock/listar/stock');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Listar Stock")')->count()
        );
    }

    public function testFraccionar()
    {
        $fraccionados = $this->em
            ->getRepository('NossisBundle:Fraccionar')
            ->findAll();
        foreach ($fraccionados as $fraccion){
            if ($fraccion->getStockDestino() == null){
                break;
            }
        }
        if ($fraccion != null){
           $client = static::createClient();
           $crawler = $client->request('GET', '/stock/fraccionar/'. $fraccion->getId());
           
           $this->assertEquals('Nossis\NossisBundle\Controller\StockController::fraccionarAction', $client->getRequest()->attributes->get('_controller'));
        
            $form = $crawler->selectButton('Guardar')->form();

            $form['nossis_nossisbundle_stock[producto]']->select('2');
            $form['nossis_nossisbundle_stock[lote]'] = 'lote';
            $form['nossis_nossisbundle_stock[fechaEnvasado]'] = '2014-03-27';
            $form['nossis_nossisbundle_stock[palet]'] = 'palet';
            $form['nossis_nossisbundle_stock[turno]']->select('A');
            $form['nossis_nossisbundle_stock[area]']->select('2');
            $form['nossis_nossisbundle_stock[ingresado]'] = "10";


            $crawler = $client->submit($form);
            $this->assertEquals('Nossis\NossisBundle\Controller\StockController::fraccionarAction', $client->getRequest()->attributes->get('_controller'));
           
        }else{
            return true;
        }
    }
    
    public function testTrazladarLote()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/stock/trazladar/lote/stock');
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Trazladar Lote Stock")')->count()
        );
    }
    
    public function testTrazladarLoteArea()
    {
        $stocks = $this->em
            ->getRepository('NossisBundle:Stock')
            ->findAll();
        foreach ($stocks as $stock){
                break;            
        }
        $areas = $this->em
            ->getRepository('NossisBundle:Area')
            ->findAll();
        foreach ($areas as $area){
                break;            
        }
        $client = static::createClient();
        $crawler = $client->request('GET', '/stock/trazladar/lote/stocks/'. $stock->getLote().'/'.$area->getId());
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("|Trazladar todo un lote")')->count()
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
