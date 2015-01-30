<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nossis\NossisBundle\Entity\Devolucion;
use Nossis\NossisBundle\Form\DevolucionType;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DevolucionController extends Controller
{
    /**
     * @Route("/devolucion/index", name="index_devolucion")
     * @Template()
     */
    public function indexAction()
    {
        $form = $this->createFormBuilder()
            ->add('buscar', 'text', array(
                'label' => 'Buscar por lote'
            ))
            ->getForm();
         $retiros = null; $lote = null;
         $request = $this->get('request');
         if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $lote = $form->getData();
            $em = $this->get('doctrine')->getManager();
            $retiros = $em->getRepository('NossisBundle:Retiro')->findLote($lote['buscar']);
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
}
