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
        
        $version = $this->getArchivoVersion();
        
        return $this->render('NossisBundle:Default:index.html.twig', array(
                'form'    => $form->createView(),
                'almacenes' => $almacenes,
                'productos' => $productos,
                'version' => $version
        ));
    }
    
    private function getArchivoVersion()
    {
        //abrimos el archivo en lectura
        $archivo = 'version.txt';
        $fp = fopen($archivo,'r');
        //leemos el archivo
        $texto = fread($fp, filesize($archivo));

        return $texto;
        
    }
    
}
