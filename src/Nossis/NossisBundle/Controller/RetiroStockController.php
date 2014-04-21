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
        $form = $this->get('form.factory')->create(
               new RetiroStockType(),
               $retirostock);
        $request = $this->get('request');
        if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $retiros = $form->getData();
            $em->persist($retiros);
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
             $em->flush();             
         }
         return $this->redirect($this->generateUrl('edit_retiro', array('id' => $retirostock->getRetiro()->getId())));
         
     }

}
