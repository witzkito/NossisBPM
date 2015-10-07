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
use Nossis\NossisBundle\Entity\Repositorio\ClienteRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
            
            return new RedirectResponse($this->generateUrl('edit_retiro', array('id' => $retiro->getId())));
                
        
    }
    
    public function editAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $retiro = $em->getRepository('NossisBundle:Retiro')->find($id);
            $formStock = $this->getFormStock($retiro);
            $request = $this->get('request');
            if ($request->getMethod() == 'POST'){
                $formStock->bind($request);
                $datos = $formStock->getData();
                if (($stock = $em->getRepository('NossisBundle:Stock')->findOneBy(array('codigo' => $datos['codigo']))) != null){
                    if ($stock->getArea()->getSalida()){
                                $retirostock = new RetiroStock;
                                $retirostock->setStock($stock);
                                $retirostock->setRetiro($retiro);
                                $retirostock->setCantidad($stock->getActual());
                                $retiro->addStock($retirostock);
                                //$cantidad = $stock->getIngresado() - $retirostock->getCantidad();
                                $stock->retirar($retirostock->getCantidad());
                                $em->persist($stock);
                            
                    }else{
                        $this->get('session')->getFlashBag()->add(
                            'notice',
                            'El articulo se encuentra en un area de no salida'
                        );
                    }                    
                    
                    
                }
                $em->flush();
                foreach ($retiro->getStocks() as $stock){
                    if (isset($datos[$stock->getId()])){
                        $stock->setCliente($datos[$stock->getId()]);
                        $em->persist($stock);
                    }
                }
                $em->persist($retiro);
                $em->flush();
                if ($request->request->has('imprimir')){
                    return new RedirectResponse($this->generateUrl('confirmar_retiro', array('id' => $retiro->getId())));
                }
            }            
            $retiro->codigo = "";
            $formStock = $this->getFormStock($retiro);
              return $this->render('NossisBundle:Retiro:edit.html.twig',
                array("retiro" => $em->getRepository('NossisBundle:Retiro')->find($id),
                    "stocks" => $em->getRepository('NossisBundle:RetiroStock')->findby(array("retiro" => $id)),
                    'formStock' => $formStock->createView()));
         
        
            
    }
    
    private function getFormStock($retiro) {
        $formStock = $this->createFormBuilder();
        $ultimoCliente = null;
        $formStock->add('codigo', 'text', array('required' => false, 'label' => null));
        foreach ($retiro->getStocks() as $stock){
            $formStock->add($stock->getId(), 'entity', array('class' => 'NossisBundle:Cliente',
                'query_builder' => function (ClienteRepository $er) {
                return $er->createQueryBuilder('u')
                ->orderBy('u.nombre', 'ASC');
              }
            ));
            if($stock->getCliente() == null){
                $formStock->get($stock->getId())->setData($ultimoCliente);
            }else{
                $formStock->get($stock->getId())->setData($stock->getCliente());
                $ultimoCliente = $stock->getCliente();
            }
            
        }
        return $formStock->getForm();
    }
    
    private function comprobarSinConfirmar($stock){
        foreach($stock->getRetiros() as $r){
            if (!$r->getRetiro()->getConfirmado()){
                return false;
            }
        }
        return true;
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
            $estadoStock->setEstado('Salida');
            $estadoStock->setDescripcion("Salida de ". $stock->getCantidad()." unidades del Almacen por " . $retiro->getTransportista());
            $estadoStock->setFecha(new \DateTime('now'));
            $em->persist($estadoStock);
        }
                        
        
        $em->flush();
        return $this->render('NossisBundle:Retiro:show.html.twig',
                array("retiro" => $retiro));
        
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
        
        $borrar = new RowAction('Borrar', 'borrar_retiro');
        $borrar->manipulateRender(
            function($action, $row)
            {
                if($row->getField('confirmado')){
                    return null;
                }else{
                    $action->setTitle('Borrar');
                }
                return $action;
            }
            );
        $borrar->setRouteParametersMapping(array('borrar.id' => 'id'));
        
        $grid->addRowAction($borrar);
        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'desc');
        return $grid->getGridResponse('NossisBundle:Retiro:listar.html.twig');
    }
    
    public function showAction($id){
        $em = $this->get('doctrine')->getManager();
        $retiro = $em->getRepository('NossisBundle:Retiro')->find($id);
        return $this->render('NossisBundle:Retiro:show.html.twig', array("retiro" => $retiro));
        
    }
    
    public function borrarAction($id){
        $em = $this->get('doctrine')->getManager();
        $retiro = $em->getRepository('NossisBundle:Retiro')->find($id);
        foreach ($retiro->getStocks() as $retiroStock){
            $retiroStock->getStock()->devolver($retiroStock->getCantidad());
            $em->persist($retiroStock->getStock());
            
            $estadoStock = new EstadoStock;
            $estadoStock->setStock($retiroStock->getStock());
            $estadoStock->setEstado('Cancelado Retiro');
            $estadoStock->setDescripcion("Se cancelo el retiro de ". $retiroStock->getCantidad() ." unidades");
            $estadoStock->setFecha(new \DateTime('now'));
            $em->persist($estadoStock);
        }
        $em->remove($retiro);
        $em->flush();
        return $this->listarAction();
    }
    
   
}
