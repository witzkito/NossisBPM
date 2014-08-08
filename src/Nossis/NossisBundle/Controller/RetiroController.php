<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Entity\Retiro;
use Nossis\NossisBundle\Form\RetiroType;
use Nossis\NossisBundle\Entity\RetiroStock;
use Symfony\Component\HttpFoundation\Response;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use Ps\PdfBundle\Annotation\Pdf;
use Nossis\NossisBundle\Entity\EstadoStock;

class RetiroController extends Controller
{
       
    public function indexAction()
    {
        $retiro = new Retiro;
        $form = $this->get('form.factory')->create(
                new RetiroType(),
                $retiro
         );
         return $this->render('NossisBundle:Retiro:index.html.twig',
                array('form' => $form->createView()));
    }
    
    public function newAction()
    {
        $retiro = new Retiro;
        $form = $this->get('form.factory')->create(
                new RetiroType(),
                $retiro
         );
        $request = $this->get('request');
        $form->bind($request);
            $retiro = $form->getData();
            $retiro->setFechaSalida(new \DateTime('NOW'));
            $retiro->setConfirmado(false);
            $em = $this->get('doctrine')->getManager();
            $em->persist($retiro);
            $em->flush();
            
            return $this->editAction($retiro->getId());
                
        
    }
    
    public function editAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        if (($retiro = $em->getRepository('NossisBundle:Retiro')->find($id)) != null){
            $form = $this->get('form.factory')->create(
                new RetiroType(),
                $retiro);
            $request = $this->get('request');
            if ($request->getMethod() == 'POST'){
                $form->bind($request);
                $retiro = $form->getData();
                if ($request->request->get('imprimir')) {
                    return $this->imprimirAction($retiro);
                }else{
                    $retiro->setFechaSalida(new \DateTime('NOW'));
                    if (($stock = $em->getRepository('NossisBundle:Stock')->findOneBy(array('codigo' => $retiro->codigo))) != null){
                        if ($stock->getArea()->getSalida()){
                            if (($retirostock = $em->getRepository('NossisBundle:RetiroStock')->findOneBy(array('retiro' => $retiro->getId(), 'stock' => $stock->getId()))) == null){
                                $retirostock = new RetiroStock;
                                $retirostock->setStock($stock);
                                $retirostock->setRetiro($retiro);
                                $retirostock->setCantidad($stock->getActual());
                                $retiro->addStock($retirostock);
                                $cantidad = $stock->getIngresado() - $retirostock->getCantidad();
                                $stock->setActual($cantidad);
                                $em->persist($stock);
                            }
                        }else{
                            $this->get('session')->getFlashBag()->add(
                                'notice',
                                'El articulo se encuentra en un area de no salida'
                            );
                        }
                    }
                    $em->persist($retiro);
                    $em->flush();
                }
            }
            $retiro->codigo = "";
            $form = $this->get('form.factory')->create(
                new RetiroType(),
                $retiro);
              return $this->render('NossisBundle:Retiro:edit.html.twig',
                array('form' => $form->createView(), "retiro" => $em->getRepository('NossisBundle:Retiro')->find($id),
                    "stocks" => $em->getRepository('NossisBundle:RetiroStock')->findby(array("retiro" => $id)) ));
         
        }
            
    }
    
    /**
    *@Pdf(stylesheet="NossisBundle:Retiro:comprobantestyle.xml")
    */
    public function imprimirAction($id){
        $em = $this->get('doctrine')->getManager();
        $retiro = $em->getRepository('NossisBundle:Retiro')->find($id);
        $stocks = $em->getRepository('NossisBundle:RetiroStock')->findby(array("retiro" => $retiro->getId()));
        
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Retiro:comprobante.pdf.twig', array("retiro" => $retiro, "stocks" => $stocks), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
        
        
    }
    
    public function confirmarAction($id){
        $em = $this->get('doctrine')->getManager();
        $retiro = $em->getRepository('NossisBundle:Retiro')->find($id);
        $retiro->setConfirmado(true);
        $em->persist($retiro);
        foreach ($retiro->getStocks() as $stock) {
            $estadoStock = new EstadoStock;
            $estadoStock->setStock($stock->getStock());
            $estadoStock->setEstado($em->getRepository('NossisBundle:Estado')->findOneBy(array('nombre' => 'Salida')));
            $estadoStock->setDescripcion("Salida de ". $stock->getCantidad()." unidades del Almacen por " . $retiro->getTransportista() . " hacia " . $retiro->getCliente());
            $estadoStock->setFecha(new \DateTime('now'));
            $em->persist($estadoStock);
        }
                        
        
        $em->flush();
        return $this->render('NossisBundle:Retiro:show.html.twig',
                array("retiro" => $em->getRepository('NossisBundle:Retiro')->find($id)));
        
    }
    
    public function listarAction(){
        $source = new Entity('NossisBundle:Retiro');

        /* @var $grid \APY\DataGridBundle\Grid\Grid */
        $grid = $this->get('grid');
        
        $ver = new RowAction('Ver', 'show_retiro');
        $ver->setRouteParametersMapping(array('retiro.id' => 'id'));
        $grid->addRowAction($ver);
        $editar = new RowAction('Editar', 'edit_retiro');
        $editar->setRouteParametersMapping(array('retiro.id' => 'id'));
        $grid->addRowAction($editar);

        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'desc');
        return $grid->getGridResponse('NossisBundle:Retiro:listar.html.twig');
    }
    
    public function showAction($id){
        $em = $this->get('doctrine')->getManager();
        $retiro = $em->getRepository('NossisBundle:Retiro')->find($id);
        return $this->render('NossisBundle:Retiro:show.html.twig', array("retiro" => $retiro));
        
    }
    
   
}
