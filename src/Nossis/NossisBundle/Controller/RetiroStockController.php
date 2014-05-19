<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Entity\RetiroStock;
use Nossis\NossisBundle\Form\RetiroStockType;

class RetiroStockController extends Controller
{
    
    public function editAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $retirostock = $em->getRepository('NossisBundle:RetiroStock')->find($id);
        $cantanterior= $retirostock->getCantidad();
        $form = $this->get('form.factory')->create(
               new RetiroStockType(),
               $retirostock);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $retiros = $form->getData();
            
            $stock = $em->getRepository('NossisBundle:Stock')->findOneBy(array('id' => $retirostock->getStock()->getId()));
            //$stock->setCantidad($cantanterior + $stock->getCantidad() - $retiros->getCantidad());
            $stock->actualizarStock($cantanterior, $retiros->getCantidad());
            $em->persist($retiros);
            $em->persist($stock);
            $em->flush();
            return $this->redirect($this->generateUrl('edit_retiro', array('id' => $retirostock->getRetiro()->getId())));
        }
        return $this->render('NossisBundle:RetiroStock:edit.html.twig',
               array('form' => $form->createView(), 'retirostock' => $retirostock));
     }
     
     public function eliminarAction($id)
     {
         $em = $this->get('doctrine')->getManager();
         $retirostock = $em->getRepository('NossisBundle:RetiroStock')->find($id);
         if ($retirostock != null){
             $em->remove($retirostock);
             $stock = $retirostock->getStock();
             $cantidad = $stock->getActual() + $retirostock->getCantidad();
             $stock->setActual($cantidad);
             $em->persist($stock);
             $em->flush();             
         }
         return $this->redirect($this->generateUrl('edit_retiro', array('id' => $retirostock->getRetiro()->getId())));
         
     }

}
