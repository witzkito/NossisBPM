<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Entity\Stock;
use Nossis\NossisBundle\Form\StockType;
use Nossis\NossisBundle\Form\StockEditType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Nossis\NossisBundle\Entity\Trazlado;
use Nossis\NossisBundle\Form\TrazladoType;
use \DateTime;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use PHPPdf\Core\Node\Barcode as Barcode;
use Zend\Barcode\Object;
use Nossis\NossisBundle\Entity\EstadoStock;
use Nossis\NossisBundle\Entity\Baja;
use APY\DataGridBundle\Grid\Source\Vector;

class StockController extends Controller
{
    public function ingresarAction($nuevo = false)
    {
         $em = $this->get('doctrine')->getManager();
         $stock = new Stock;
         $form = $this->get('form.factory')->create(
                new StockType(),
                $stock
         );
         $ultimosStock = $em->getRepository('NossisBundle:Stock')->findLast();
         
         return $this->render('NossisBundle:Stock:ingresar.html.twig',
                array( 'form' => $form->createView(), 'ultimos' => $ultimosStock,
                    'first' => $nuevo
                ));         
    }
    
    public function agregarAction()
    {
        $em = $this->get('doctrine')->getManager();
        $stock = new Stock;
        $form = $this->get('form.factory')->create(
                new StockType(),
                $stock
         );
        $request = $this->get('request');
        $form->bind($request);
        //if ($form->isValid()){

            $stock = $form->getData();
            $stock->setFechaIngreso(new \DateTime('NOW'));
            $stock->setCodigo(0);
            $stock->setActual($stock->getIngresado());
            
            $estadoStock = new EstadoStock;
            $estadoStock->setEstado('Ingresado');
            $estadoStock->setStock($stock);
            $estadoStock->setDescripcion("Ingresado al area ". $stock->getArea()->getNombre());
            $estadoStock->setFecha(new \DateTime('NOW'));
            
            $em->persist($stock);
            $em->persist($estadoStock);
            $em->flush();
            $stock->setCodigo($this->getCodigoBarra($stock));
            $numero = $em->getRepository('NossisBundle:Stock')->getNumeroStock();
            $stock->setNumero($numero[0][1] + 1 . '/'. $estadoStock->getFecha()->format('y'));
            $em->persist($stock);
            $em->flush();
            
           
            return $this->ingresarAction(true); 
                
        //}
    }
    
    private function getCodigoBarra($stock){
        $codigo = $stock->getLote();
        $codigo = $codigo. $stock->getPalet();
        $codigo = $codigo. $stock->getTurno();
        $codigo = $codigo. $stock->getId();
        return $codigo;
    }
    
    public function indexAction(){
        $form = $this->createFormBuilder()
            ->add('codigo')
            ->getForm();
        $request = $this->get('request');
        $form->bind($request);
        $datos = $form->getData();
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->findOneBy(array('codigo' => $datos['codigo']));
        if ($stock == null){
            $stock = $em->getRepository('NossisBundle:Stock')->findOneBy(array('numero' => $datos['codigo']));
        }
        if ($stock == null){
            return $this->redirect($this->generateUrl('nossis_homepage'));
        }else{
            return $this->showAction($stock->getId());
        }
             
        
    }
    
    public function showAction($id){
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        
        $bmanager = $this->container->get('mopa_barcode.barcode_service');
        $webfile = $bmanager->get('code128', $stock->getCodigo());
        
        return $this->render('NossisBundle:Stock:show.html.twig',
                array( 'stock' => $stock, 'barcode_url'=>$webfile,)); 
    }
    
    public function trazladarAction($id){
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        $trazlado = new Trazlado;
        $form = $this->get('form.factory')->create(
                new TrazladoType(),
                $trazlado
         );
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){
            $trazlado = $form->getData();
            $stock->setArea($trazlado->getArea());
            $trazlado->setFecha(new DateTime('now'));
            $trazlado->setStock($stock);
            
            $estadoStock = new EstadoStock;
            $estadoStock->setStock($stock);
            $estadoStock->setEstado('Trazlado');
            $estadoStock->setDescripcion("Se trazlado al area " . $trazlado->getArea()->getNombre());
            $estadoStock->setFecha(new DateTime('now'));
            
            $em->persist($trazlado);
            $em->persist($stock);
            $em->persist($estadoStock);
            $em->flush();
            return $this->showAction($stock->getId());
        }
        return $this->render('NossisBundle:Stock:trazladar.html.twig',
                array( 'form' => $form->createView(), 'stock' => $stock));
    }
    
    public function listaringresoAction(){
        $source = new Entity('NossisBundle:Stock');

        /* @var $grid \APY\DataGridBundle\Grid\Grid */
        $grid = $this->get('grid');
        
        $ver = new RowAction('Ver', 'show_stock');
        $ver->setRouteParametersMapping(array('stock.id' => 'id'));
        $grid->addRowAction($ver);
        $editar = new RowAction('Editar', 'editar_stock');
        $editar->setRouteParametersMapping(array('stock.id' => 'id'));
        $grid->addRowAction($editar);
        $imprimir = new RowAction('Imprimir', 'imprimir_stock');
        $imprimir->setRouteParametersMapping(array('stock.id' => 'id'));
        $grid->addRowAction($imprimir);

        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'desc');
        return $grid->getGridResponse('NossisBundle:Stock:listarIngreso.html.twig');
    }
    
    public function listarStockAction(){
        $em = $this->get('doctrine')->getManager();
        $productos = $em->getRepository('NossisBundle:Producto')->findAll();
        
        return $this->render('NossisBundle:Stock:listar.html.twig',
                array( 'productos' => $productos));   
    }
    
     public function editarAction($id)
    {
         $em = $this->get('doctrine')->getManager();
         $stock = $em->getRepository('NossisBundle:Stock')->find($id);
         $form = $this->get('form.factory')->create(
                new StockEditType(),
                $stock
         );
         $request = $this->get('request');
         if ($request->getMethod() == 'POST'){
            $form->bind($request);
            if($form->isValid()){
                $stock = $form->getData();
                $estadoStock = new EstadoStock;
                $estadoStock->setEstado('Modificado');
                $estadoStock->setStock($stock);
                $estadoStock->setDescripcion("Se realizaron modificaciones por motivo: " . $stock->motivoEdicion);
                $estadoStock->setFecha(new \DateTime('NOW'));
                
                $em->persist($stock);
                $em->persist($estadoStock);
                $em->flush();
                return $this->redirect($this->generateUrl('show_stock', array('id' => $stock->getId())));
            }
         }    
         return $this->render('NossisBundle:Stock:editar.html.twig',
                array( 'form' => $form->createView(), 'stock' => $stock));         
    }
    
    public function imprimirAction($id){
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        
        $bmanager = $this->container->get('mopa_barcode.barcode_service');
        $webfile = $bmanager->get('code128', $stock->getCodigo());
        
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Stock:comprobante.pdf.twig', array("stock" => $stock, 'barcode_url' => $webfile), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
                
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    public function fraccionarAction($id){
        $em = $this->get('doctrine')->getManager();
        $fraccionar = $em->getRepository('NossisBundle:Fraccionar')->find($id);
        $stock = new Stock;
        $form = $this->get('form.factory')->create(
            new StockType(),
            $stock
        );
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){

            $stock = $form->getData();
            $stock->setFechaIngreso(new \DateTime('NOW'));
            $stock->setCodigo(0);
            $stock->setActual($stock->getIngresado());
            $stock->setOrigenFraccionado($fraccionar);
            
            $estadoStock = new EstadoStock;
            $estadoStock->setEstado("Ingresado");
            $estadoStock->setStock($stock);
            $estadoStock->setDescripcion("Ingresado al area ". $stock->getArea()->getNombre() ." origen fraccionado");
            $estadoStock->setFecha(new \DateTime('NOW'));
            
            $em->persist($stock);
            $em->persist($estadoStock);
            $fraccionar->setStockDestino($stock);
            $em->persist($fraccionar);
            $em->flush();
            $stock->setCodigo($this->getCodigoBarra($stock));
            $em->persist($stock);
            $em->flush();
            return $this->ingresarAction(true);
            
        }
        return $this->render('NossisBundle:Stock:fraccionar.html.twig',
                array( 'form' => $form->createView(),
                    'stock' => $stock,
                    'fraccionar' => $fraccionar,
                    'ultimos' => $em->getRepository('NossisBundle:Stock')->findLast(),
                    'first' => false));
         
    }
    
    public function trazladarLoteAction(){
        $form = $this->createFormBuilder()
            ->add('area', 'genemu_jqueryselect2_entity', array(
                "class" => "Nossis\NossisBundle\Entity\Area",
                'label' => 'Areas'))
            ->getForm();
        $request = $this->get('request');
        $lotes = null; $area = null;
         if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $area = $form->getData()['area'];
            $lotes = $area->getLotesStock();
         }
        return $this->render('NossisBundle:Stock:trazladarLote.html.twig',
                 array('form' => $form->createView(), 'lotes' => $lotes, 'area' => $area));
    }
    
    public function trazladarLoteAreaAction($lote, $area, $timestamp){
        $trazlado = new Trazlado;
        $form = $this->get('form.factory')->create(
                new TrazladoType(),
                $trazlado
         );
            $fecha = DateTime::createFromFormat( 'U', $timestamp );
            $fecha = $fecha->sub(\DateInterval::createFromDateString('+ 3 hours'));
        $request = $this->get('request');
         if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $trazlado = $form->getData();
            $em = $this->get('doctrine')->getManager();
            $fecha = DateTime::createFromFormat( 'U', $timestamp );
            $fecha = $fecha->sub(\DateInterval::createFromDateString('+ 3 hours'));
            $stocks = $em->getRepository('NossisBundle:Stock')->findBy(array('lote' => $lote, 'area' => $area, 'fechaEnvasado' => $fecha));
            foreach ($stocks as $stock){                    
                $stock->setArea($trazlado->getArea());
                $trazlado->setFecha(new DateTime('now'));
                $trazlado->setStock($stock);

                $estadoStock = new EstadoStock;
                $estadoStock->setStock($stock);
                $estadoStock->setEstado('Trazlado');
                $estadoStock->setDescripcion("Se trazlado al area " . $trazlado->getArea()->getNombre());
                $estadoStock->setFecha(new DateTime('now'));

                $em->persist($trazlado);
                $em->persist($stock);
                $em->persist($estadoStock);                
            }
            $em->flush();
            return $this->indexAction();
         }
        return $this->render('NossisBundle:Stock:trazladarLoteArea.html.twig',
                 array('form' => $form->createView(), 'lote' => $lote, 'area' => $area, 'fecha' => $timestamp));
    }
    
    /*public function destruirAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        
        $estadoStock = new EstadoStock;
        $estadoStock->setStock($stock);
        $estadoStock->setEstado('Destruido');
        $estadoStock->setDescripcion($stock->getActual() . " unidades del producto fueron destruido");
        $estadoStock->setFecha(new DateTime('now'));
                
        $baja = new Baja();
        $baja->setFecha(new \DateTime());
        $baja->setStock($stock);
        $baja->setCantidad($stock->getActual());
        $stock->setActual(0);
        $em->persist($baja);
        $em->persist($stock);
        $em->persist($estadoStock);                
        
        $em->flush();            
         
        return $this->indexAction();
    }*/
    
     public function listarDestruidoAction(){
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->findAll();
        $vector = array();
        foreach ($stock as $s)
        {
            foreach ($s->getEstados() as $estado)
            {
                if ($estado->getEstado() == "Destruido"){
                    $vector[] = array(
                        'id' => $s->getId(),
                        'fecha' => $estado->getFecha(),
                        'nro' => $s->getNumero(),
                        'producto' => $s->getProducto(),
                        'descripcion' => $estado->getDescripcion(),
                    );
                    
                }
            }
            
        }
        
        $source = new Vector($vector);

        /* @var $grid \APY\DataGridBundle\Grid\Grid */
        $grid = $this->get('grid');
        
        $ver = new RowAction('Ver', 'show_stock');
        $ver->setRouteParametersMapping(array('stock.id' => 'id'));
        $grid->addRowAction($ver);
        
        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'desc');
        return $grid->getGridResponse('NossisBundle:Stock:listarDestruido.html.twig');
    }
}