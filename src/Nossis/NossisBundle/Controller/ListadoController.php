<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class ListadoController extends Controller
{
    /**
     * @Route("/listar/general/index", name="index_listado_general")
     * @Template()
     */
    public function indexAction()
    {
        $form = $this->crearFormulario();
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){
            $datos = $form->getData();
            if ($datos['mostrar'] == "Stock-Actual"){
                return $this->mostrarStockActual($datos);
            }else{
                
            }
        }
        return $this->render('NossisBundle:Listado:index.html.twig', array(
                "form" => $form->createView()));
     }
     
     private function crearFormulario(){
        return $this->createFormBuilder()
            ->add('desde', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'))
            ->add('hasta', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'))
            ->add('producto', 'genemu_jqueryselect2_entity', array(
                'class' => 'NossisBundle:Producto',
                'required' => false
            ))
            ->getForm();
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/lote", name="stock_actual_lote_listado_general")
     * @Template()
     */
    public function mostrarStockActualLoteAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLote();
        $form = $this->crearFormulario();
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){
            $datos = $form->getData();
            return $this->mostrarStockActualLoteFechaAction($datos);
        }
        return $this->render('NossisBundle:Listado:mostrarStockActualLote.html.twig', array(
                "entities" => $entities, "form" => $form->createView()));        
    }
    
    /**
     * @Route("/listar/general/movimiento/producto", name="movimiento_producto_listado_general")
     * @Template()
     */
    public function mostrarMovimientoProductoAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $this->generarArrayMovimientoProductos();
        $form = $this->crearFormularioMovimientoProducto();
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){
            $datos = $form->getData();
            return $this->mostrarMovimientoProductoFechaAction($datos);
        }
        return $this->render('NossisBundle:Listado:mostrarMovimientoProducto.html.twig', array(
                "entities" => $entities, "form" => $form->createView()));        
    }
    
    public function generarArrayMovimientoProductos()
    {
        $em = $this->get('doctrine')->getManager();
        $productos = $em->getRepository('NossisBundle:Producto')->findAll();
        $entities = array();
        foreach ($productos as $producto)
        {
            $entities[$producto->getNombre()]['producto'] = $producto;
            $entities[$producto->getNombre()]['ingresos'] = 0;
            $entities[$producto->getNombre()]['despachos'] = 0;
            $entities[$producto->getNombre()]['devolucion'] = 0;
            $entities[$producto->getNombre()]['fraccionado'] = 0;
            $entities[$producto->getNombre()]['bajas'] = 0;
            foreach ($producto->getStocks() as $stock)
            {
                $entities[$producto->getNombre()]['ingresos'] = $entities[$producto->getNombre()]['ingresos'] + $stock->getIngresado();
                
                foreach ($stock->getRetiros() as $retiro)
                {
                    $entities[$producto->getNombre()]['despachos'] = $entities[$producto->getNombre()]['despachos'] + $retiro->getCantidad();
                    
                    foreach ($retiro->getDevoluciones() as $devolucion)
                    {
                        $entities[$producto->getNombre()]['devolucion'] = $entities[$producto->getNombre()]['devolucion'] + $devolucion->getCantidad();
                    }
                }
                foreach ($stock->getDestrucciones() as $baja)
                {
                    $entities[$producto->getNombre()]['bajas'] = $entities[$producto->getNombre()]['bajas'] + $baja->getCantidad();
                }
                foreach ($stock->getFraccionados() as $fraccionado)
                {
                    $entities[$producto->getNombre()]['fraccionado'] = $entities[$producto->getNombre()]['fraccionado'] + $fraccionado->getCantidad();
                }
                
            }
        }
        return $entities;
    }
    
    private function crearFormularioMovimientoProducto(){
        return $this->createFormBuilder()
            ->add('desde', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'))
            ->add('hasta', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy'))
            ->getForm();
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/producto", name="stock_actual_producto_listado_general")
     * @Template()
     */
    public function mostrarStockActualProductoAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Producto')->findAll();
        $form = $this->crearFormulario();
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){
            $datos = $form->getData();
            return $this->mostrarStockActualProductoFechaAction($datos);
        }
        return $this->render('NossisBundle:Listado:mostrarStockActualProducto.html.twig', array(
                "entities" => $entities, "form" => $form->createView()));        
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/unidad", name="stock_actual_unidad_listado_general")
     * @Template()
     */
    public function mostrarStockActualUnidadAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Stock')->findAll();
        $form = $this->crearFormulario();
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){
            $datos = $form->getData();
            return $this->mostrarStockActualUnidadFechaAction($datos);
        }
        return $this->render('NossisBundle:Listado:mostrarStockActualUnidad.html.twig', array(
                "entities" => $entities, "form" => $form->createView()));        
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/lote/imprimir", name="imprimir_stock_actual_lote_listado_general")
     * @Template()
     */
    public function imprimirStockActualLoteAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLote();
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarStockActualLote.pdf.twig', array("entities" => $entities), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/producto/imprimir", name="imprimir_stock_actual_producto_listado_general")
     * @Template()
     */
    public function imprimirStockActualProductoAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Producto')->findAll();
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarStockActualProducto.pdf.twig', array("entities" => $entities), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
   public function mostrarStockActualLoteFechaAction($datos){
        $em = $this->get('doctrine')->getManager();
        if ($datos['producto'] != null)
        {
            $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLoteFecha($datos['desde'], $datos['hasta'], $datos['producto']->getId());
        }else{
            $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLoteFecha($datos['desde'], $datos['hasta']);
        }
        $session = new Session();
        $session->set('desde', $datos['desde']);
        $session->set('hasta', $datos['hasta']);
        $session->set('producto', $datos['producto']);
        return $this->render('NossisBundle:Listado:mostrarStockActualLoteFecha.html.twig', array(
                "entities" => $entities, 'desde' => $datos['desde'], 'hasta' => $datos['hasta'], 'producto' => $datos['producto']));        
    }
    
    public function mostrarMovimientoProductoFechaAction($datos){
        $session = new Session();
        $session->set('desde', $datos['desde']);
        $session->set('hasta', $datos['hasta']);
        $entities = $this->generarArrayMovimientoProducto($datos['desde'], $datos['hasta']);
        
        return $this->render('NossisBundle:Listado:mostrarMovimientoProductoFecha.html.twig', array(
                "entities" => $entities, 'desde' => $datos['desde'], 'hasta' => $datos['hasta']));        
    }
    
    public function generarArrayMovimientoProducto($desde, $hasta)
    {
        $em = $this->get('doctrine')->getManager();
        $productos = $em->getRepository('NossisBundle:Producto')->findAll();
        $entities = array();
        foreach ($productos as $producto)
        {
            $entities[$producto->getNombre()]['ingresos'] = 0;
            $entities[$producto->getNombre()]['despachos'] = 0;
            $entities[$producto->getNombre()]['fraccionado'] = 0;
            $entities[$producto->getNombre()]['devolucion'] = 0;
            $entities[$producto->getNombre()]['bajas'] = 0;
            foreach ($producto->getStocks() as $stock)
            {
                if ($stock->getFechaIngreso() >= $desde && $stock->getFechaIngreso() <= $hasta)
                {
                    $entities[$producto->getNombre()]['ingresos'] = $entities[$producto->getNombre()]['ingresos'] + $stock->getIngresado();
                }
                foreach ($stock->getRetiros() as $retiro)
                {
                    if ($retiro->getRetiro()->getFechaSalida() >= $desde && $retiro->getRetiro()->getFechaSalida() <= $hasta)
                    {
                        $entities[$producto->getNombre()]['despachos'] = $entities[$producto->getNombre()]['despachos'] + $retiro->getCantidad();
                    }
                    foreach ($retiro->getDevoluciones() as $devolucion)
                    {
                        if ($devolucion->getFecha() >= $desde && $devolucion->getFecha() <= $hasta)
                        {
                            $entities[$producto->getNombre()]['devolucion'] = $entities[$producto->getNombre()]['devolucion'] + $devolucion->getCantidad();
                        }
                    }
                }
                foreach ($stock->getDestrucciones() as $baja)
                {
                    if ($baja->getFecha() >= $desde && $baja->getFecha() <= $hasta)
                    {
                        $entities[$producto->getNombre()]['bajas'] = $entities[$producto->getNombre()]['bajas'] + $baja->getCantidad();
                    }
                }
                foreach ($stock->getFraccionados() as $fraccionado)
                {
                    $entities[$producto->getNombre()]['fraccionado'] = $entities[$producto->getNombre()]['fraccionado'] + $fraccionado->getCantidad();
                }
            }
        }
        return $entities;
    }
    
    public function mostrarStockActualUnidadFechaAction($datos){
        $em = $this->get('doctrine')->getManager();
        if ($datos['producto'] != null)
        {
            $entities = $em->getRepository('NossisBundle:Stock')->findAllFecha($datos['desde'], $datos['hasta'], $datos['producto']->getId());
        }else{
            $entities = $em->getRepository('NossisBundle:Stock')->findAllFecha($datos['desde'], $datos['hasta']);
        }
        $session = new Session();
        $session->set('desde', $datos['desde']);
        $session->set('hasta', $datos['hasta']);
        $session->set('producto', $datos['producto']);
        return $this->render('NossisBundle:Listado:mostrarStockActualUnidadFecha.html.twig', array(
                "entities" => $entities, 'desde' => $datos['desde'], 'hasta' => $datos['hasta'], 'producto' => $datos['producto']));        
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/unidad/imprimir", name="imprimir_stock_actual_unidad_listado_general")
     * @Template()
     */
    public function imprimirStockActualUnidadAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Stock')->findAll();$facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarStockActualUnidad.pdf.twig', array("entities" => $entities), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    /**
     * @Route("/listar/general/movimiento/producto/imprimir", name="imprimir_movimiento_producto_listado_general")
     * @Template()
     */
    public function imprimirMovimientoProductoAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $this->generarArrayMovimientoProductos();
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarMovimientoProducto.pdf.twig', array("entities" => $entities), $response);
        $facade = $this->get('ps_pdf.facade');
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    public function mostrarStockActualProductoFechaAction($datos){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Producto')->findAllFecha($datos['desde'], $datos['hasta']);
        $session = new Session();
        $session->set('desde', $datos['desde']);
        $session->set('hasta', $datos['hasta']);
        return $this->render('NossisBundle:Listado:mostrarStockActualProductoFecha.html.twig', array(
                "entities" => $entities, 'desde' => $datos['desde'], 'hasta' => $datos['hasta']));        
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/lote/fecha/imprimir", name="imprimir_stock_actual_lote_fecha_listado_general")
     * @Template()
     */
    public function imprimirStockActualLoteFechaAction(){
        $em = $this->get('doctrine')->getManager();
        $session = new Session();
        $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLoteFecha($session->get('desde'), $session->get('hasta'), $session->get('producto'));
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarStockActualLoteFecha.pdf.twig', array("entities" => $entities, "desde" => $session->get('desde'),
            "hasta" => $session->get('hasta'), "producto" => $session->get('producto')), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    /**
     * @Route("/listar/general/movimiento/producto/fecha/imprimir", name="imprimir_movimiento_producto_fecha_listado_general")
     * @Template()
     */
    public function imprimirMovimientoProductoFechaAction(){
        $em = $this->get('doctrine')->getManager();
        $session = new Session();
        $entities = $this->generarArrayMovimientoProducto($session->get('desde'), $session->get('hasta'));
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarMovimientoProductoFecha.pdf.twig', array("entities" => $entities, "desde" => $session->get('desde'),
            "hasta" => $session->get('hasta')), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/producto/fecha/imprimir", name="imprimir_stock_actual_producto_fecha_listado_general")
     * @Template()
     */
    public function imprimirStockActualProductoFechaAction(){
        $em = $this->get('doctrine')->getManager();
        $session = new Session();
        $entities = $em->getRepository('NossisBundle:Producto')->findAllFecha($session->get('desde'), $session->get('hasta'), $session->get('producto'));
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarStockActualProductoFecha.pdf.twig', array("entities" => $entities, "desde" => $session->get('desde'), "hasta" => $session->get('hasta')), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/unidad/fecha/imprimir", name="imprimir_stock_actual_unidad_fecha_listado_general")
     * @Template()
     */
    public function imprimirStockActualUnidadFechaAction(){
        $em = $this->get('doctrine')->getManager();
        $session = new Session();
        if ($session->get('producto') != null)
        {
            $entities = $em->getRepository('NossisBundle:Stock')->findAllFecha($session->get('desde'), $session->get('hasta'), $session->get('producto')->getId());
        }else{
            $entities = $em->getRepository('NossisBundle:Stock')->findAllFecha($session->get('desde'), $session->get('hasta'));
        }
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarStockActualUnidadFecha.pdf.twig', array("entities" => $entities, "desde" => $session->get('desde'), "hasta" => $session->get('hasta'), "producto" => $session->get('producto')), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }
    
    /**
     * @Route("/listar/discrepancia", name="listado_discrepancia")
     * @Template()
     */
    public function listarDiscrepanciaAction(){
        $em = $this->get('doctrine')->getManager();
        $stocks = $em->getRepository('NossisBundle:Stock')->findAll();
        $retornar = array();
        foreach ($stocks as $stock)
        {
            $actual = $stock->getActual();
            $ingresado = $stock->getIngresado();
            $retirado = $stock->getCantidadRetirado();
            $fraccionado = $stock->getCantidadFraccionado();
            $devuelto = $stock->getCantidadDevuelto();
            $destruido = $stock->getCantidadDestruido();
            if ($actual != ($ingresado + $devuelto - $retirado - $fraccionado - $destruido))
            {
                $retornar[$stock->getId()] = $stock;
            }
            if ($actual < 0)
            {
                $retornar[$stock->getId()] = $stock;
            }
        }
        return $this->render('NossisBundle:Listado:discrepancia.html.twig', array(
                "entities" => $retornar));        
       
    }

}
