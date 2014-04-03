<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Entity\Stock;
use Nossis\NossisBundle\Form\StockType;
use Symfony\Component\HttpFoundation\Response;

class StockController extends Controller
{
    public function ingresarAction()
    {
         $em = $this->get('doctrine')->getManager();
         $stock = new Stock;
         $form = $this->get('form.factory')->create(
                new StockType(),
                $stock
         );
         $ultimosStock = $em->getRepository('NossisBundle:Stock')->findLast();
         
         return $this->render('NossisBundle:Stock:ingresar.html.twig',
                array( 'form' => $form->createView(), 'ultimos' => $ultimosStock
                ));         
    }
    
    public function agregarAction()
    {
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
            $em = $this->get('doctrine')->getManager();
            $em->persist($stock);
            $em->flush();
            $stock->setCodigo($stock->getProducto()->getCodigo() . $stock->getId());
            $em->persist($stock);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add(
            'mensaje_ok',
            'El stock fue ingresado correctamente!!'
            );
            return $this->ingresarAction(); 
                
        }
    }

}
