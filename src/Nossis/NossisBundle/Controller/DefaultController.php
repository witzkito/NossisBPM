<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $form = $this->createFormBuilder()
                        ->add('codigo', 'text', array("label" => false))
                        ->getForm();
        
        $em = $this->get('doctrine')->getManager();
        $almacenes = $em->getRepository('NossisBundle:Almacen')->findAll();
        $productos = $em->getRepository('NossisBundle:Producto')->findAll();
        $request = $this->get('request');
        if ($request->getMethod() == 'POST'){
            
        }
        
        return $this->render('NossisBundle:Default:index.html.twig', array(
                'form'    => $form->createView(),
                'almacenes' => $almacenes,
                'productos' => $productos,
        ));
    }
}
