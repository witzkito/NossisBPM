<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nossis\NossisBundle\Entity\Devolucion;
use Nossis\NossisBundle\Form\DevolucionType;
use Nossis\NossisBundle\Form\DevolucionTodoType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;

class DevolucionController extends Controller
{
    /**
     * @Route("/devolucion/index", name="index_devolucion")
     * @Template()
     */
    public function indexAction()
    {
        $form = $this->createFormBuilder()
            ->add('cliente', 'genemu_jqueryselect2_entity', array(
                "class" => "Nossis\NossisBundle\Entity\Cliente",
                'label' => 'Cliente'))
            ->getForm();
         $retiros = null; $lote = null;
         $request = $this->get('request');
         if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $cliente = $form->getData();
            $em = $this->get('doctrine')->getManager();
            //$retiros = $em->getRepository('NossisBundle:Retiro')->findBy(array('cliente' => $cliente['cliente']->getId()));
            $retiros = $em->getRepository('NossisBundle:Retiro')->findClientes($cliente['cliente']->getId());
         }
        
        return $this->render('NossisBundle:Devolucion:index.html.twig',
                array('lote' => $lote['buscar'], 'retiros' => $retiros, 'form' => $form->createView()));     
    }
    
    /**
     * @Route("/devolucion/nuevo/{id}", name="nuevo_devolucion")
     * @Template()
     */
    public function nuevoAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $retiroStock = $em->getRepository('NossisBundle:RetiroStock')->find($id);
        $devolucion = new Devolucion();
        $devolucion->setRetiroStock($retiroStock);
        $form = $this->get('form.factory')->create(
                new DevolucionType(),
                $devolucion
         );
        $request = $this->get('request');
         if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $devolucion = $form->getData();
            $devolucion->setFecha(new \DateTime('NOW'));
            
            $estado = new \Nossis\NossisBundle\Entity\EstadoStock();
            $estado->setDescripcion($devolucion->getCantidad() . " productos fueron devueltos por motivo " . $devolucion->getMotivo());
            $estado->setEstado('Devuelto');
            $estado->setFecha(new \DateTime('NOW'));
            $estado->setStock($retiroStock->getStock());
            $retiroStock->getStock()->actualizarStock($devolucion->getCantidad(), 0);
            $em->persist($estado);
            $em->persist($devolucion);
            $em->persist($retiroStock);
            $em->persist($retiroStock->getStock());
            $em->flush();
            return new RedirectResponse($this->generateUrl('show_stock',array('id' => $retiroStock->getStock()->getId())));
         }
        return $this->render('NossisBundle:Devolucion:nuevo.html.twig',
                array('stock' => $retiroStock, 'form' => $form->createView()));
    }
    
    /**
     * @Route("/devolucion/mostrar/{id}", name="mostrar_devolucion")
     * @Template()
     */
    public function mostrarAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $devolucion = $em->getRepository('NossisBundle:Devolucion')->find($id);
        return $this->render('NossisBundle:Devolucion:mostrar.html.twig',
                array('devolucion' => $devolucion));
    }
    
    /**
     * @Route("/devolucion/eliminar/{id}/{id_stock}", name="eliminar_devolucion")
     * @Template()
     */
    public function eliminarAction($id, $id_stock)
    {
        $em = $this->get('doctrine')->getManager();
        $devolucion = $em->getRepository('NossisBundle:Devolucion')->find($id);
        $stock = $em->getRepository('NossisBundle:Stock')->find($id_stock);
        if ($devolucion != null && $stock != null)
        {
            $stock->retirar($devolucion->getCantidad());
            $estado = new \Nossis\NossisBundle\Entity\EstadoStock();
            $estado->setDescripcion("Se elimino devolucion de: ". $devolucion->getCantidad() . " productos por motivo " . $devolucion->getMotivo());
            $estado->setEstado('Eliminacion');
            $estado->setFecha(new \DateTime('NOW'));
            $estado->setStock($stock);
            $em->persist($stock);
            $em->persist($estado);
            $em->remove($devolucion);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('show_stock', array('id' => $stock->getId())));
    }
    
    /**
     * @Route("/devolucion/todo/{id}", name="todo_devolucion")
     * @Template()
     */
    public function todoAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $retiro = $em->getRepository('NossisBundle:Retiro')->find($id);
        if ($retiro != null) {
            $devolucion = new Devolucion();                    
            $form = $this->get('form.factory')->create(
                    new DevolucionTodoType(), $devolucion
            );
            $request = $this->get('request');
            if ($request->getMethod() == 'POST') {
                $form->bind($request);
                
                $entity = $form->getData();
                
                foreach ($retiro->getStocks() as $retiroStock) {
                    $devolucion = new Devolucion();
                    $devolucion->setRetiroStock($retiroStock);
                    $devolucion->setFecha(new \DateTime('NOW'));
                    $devolucion->setMotivo($entity->getMotivo());
                    $devolucion->setCantidad($retiroStock->getCantidad());

                    $estado = new \Nossis\NossisBundle\Entity\EstadoStock();
                    $estado->setDescripcion($devolucion->getCantidad() . " productos fueron devueltos por motivo " . $devolucion->getMotivo());
                    $estado->setEstado('Devuelto');
                    $estado->setFecha(new \DateTime('NOW'));
                    $estado->setStock($retiroStock->getStock());
                    $retiroStock->getStock()->actualizarStock($devolucion->getCantidad(), 0);
                    $em->persist($estado);
                    $em->persist($devolucion);
                    $em->persist($retiroStock);
                    $em->persist($retiroStock->getStock());
                }
                $em->flush();
                return new RedirectResponse($this->generateUrl('show_stock', array('id' => $retiroStock->getStock()->getId())));
            }
            return $this->render('NossisBundle:Devolucion:nuevoTodo.html.twig', array('retiro' => $retiro, 'form' => $form->createView()));
        }
    }
    
    /**
     * @Route("/devolucion/listar", name="list_devolucion")
     * @Template()
     */
    public function listarAction(){
        $source = new Entity('NossisBundle:Devolucion');

        /* @var $grid \APY\DataGridBundle\Grid\Grid */
        $grid = $this->get('grid');
        
        $ver = new RowAction('Ver', 'show_devolucion');
        $grid->addRowAction($ver);
        /*$editar = new RowAction('Editar', 'edit_devolucion');
        $editar->setRouteParametersMapping(array('devolucion.id' => 'id'));
        $grid->addRowAction($editar);*/
        
        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'desc');
        return $grid->getGridResponse('NossisBundle:Devolucion:listar.html.twig');
    }
    
    /**
     * @Route("/devolucion/show/{id}", name="show_devolucion")
     * @Template()
     */
    public function showAction($id){
        $em = $this->get('doctrine')->getManager();
        $entity = $em->getRepository('NossisBundle:Devolucion')->find($id);
        return $this->render('NossisBundle:Devolucion:show.html.twig', array("entity" => $entity));
        
    }
}
