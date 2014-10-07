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
            ->add('mostrar', 'choice', array(
                "choices" => array("Stock-Actual" => "Stock Actual"),
                "label" => "¿Que mostrar?"
            ))
            ->add('como', 'choice', array(
                "choices" => array("lote" => "Lote", "unidad" => "unidad"),
                "label" => "¿Como?"
            ))
            ->add('fecha', 'checkbox', array(
                "label" => "¿Por Rango de Fecha?",
                "required" => false
            ))    
            ->add('desde', 'genemu_jquerydate', array(
                'widget' => 'single_text'))
            ->add('hasta', 'genemu_jquerydate', array(
                'widget' => 'single_text'))    
            ->getForm();
    }
    
    private function mostrarStockActual($datos){
        if ($datos['como'] == "lote"){
            $retorno = $this->mostrarStockActualLote($datos);
        }else{
            
        }
        return $retorno;
    }
    
    private function mostrarStockActualLote($datos){
        if ($datos['fecha']){
            return $this->mostrarStockActualLoteFechaAction($datos);
        }else{
            return $this->redirect($this->generateUrl('stock_actual_lote_listado_general'));            
        }
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/lote", name="stock_actual_lote_listado_general")
     * @Template()
     */
    public function mostrarStockActualLoteAction(){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLote();
        return $this->render('NossisBundle:Listado:mostrarStockActualLote.html.twig', array(
                "entities" => $entities));        
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
    
   public function mostrarStockActualLoteFechaAction($datos){
        $em = $this->get('doctrine')->getManager();
        $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLoteFecha($datos['desde'], $datos['hasta']);
        $session = new Session();
        $session->set('desde', $datos['desde']);
        $session->set('hasta', $datos['hasta']);
        return $this->render('NossisBundle:Listado:mostrarStockActualLoteFecha.html.twig', array(
                "entities" => $entities, 'desde' => $datos['desde'], 'hasta' => $datos['hasta']));        
    }
    
    /**
     * @Route("/listar/general/index/stock/actual/lote/fecha/imprimir", name="imprimir_stock_actual_lote_fecha_listado_general")
     * @Template()
     */
    public function imprimirStockActualLoteFechaAction(){
        $em = $this->get('doctrine')->getManager();
        $session = new Session();
        $entities = $em->getRepository('NossisBundle:Stock')->mostrarStockActualLoteFecha($session->get('desde'), $session->get('hasta'));
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Listado:mostrarStockActualLoteFecha.pdf.twig', array("entities" => $entities, "desde" => $session->get('desde'), "hasta" => $session->get('hasta')), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }

}
