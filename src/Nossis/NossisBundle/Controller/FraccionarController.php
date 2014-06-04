<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Form\FraccionarType;
use Nossis\NossisBundle\Entity\Fraccionar;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Nossis\NossisBundle\Entity\EstadoStock;

class FraccionarController extends Controller
{
    
    public function indexAction($id){
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        $fraccionar = new Fraccionar;
        $fraccionar->setStock($stock);
        $fraccionar->setCantidad($stock->getActual());
        $form = $this->get('form.factory')->create(
                new FraccionarType(),
                $fraccionar
        );
        $request = $this->get('request');
            if ($request->getMethod() == 'POST'){
                $form->bind($request);
                $fraccionar = $form->getData();
                $fraccionar->setFecha(new \DateTime('now'));
                
                $stock->retirarStock($fraccionar->getCantidad());
                
                $estado = $em->getRepository('NossisBundle:Estado')->findOneBy(array('nombre' => 'Fraccionado'));
                $estadoStock = new EstadoStock;
                $estadoStock->setEstado($estado);
                $estadoStock->setStock($stock);
                $estadoStock->setDescripcion("Se retiro la cantidad de ". $fraccionar->getCantidad() ." unidades para fraccionado");
                $estadoStock->setFecha(new \DateTime('NOW'));
            
                $em->persist($fraccionar);
                $em->persist($stock);
                $em->persist($estadoStock);
                $em->flush();
                return new RedirectResponse($this->generateUrl('show_stock',array('id' => $stock->getId())));
            }
        return $this->render('NossisBundle:Fraccionar:index.html.twig',
                array('fraccionar' => $fraccionar, 'form' => $form->createView()));     
    }
    
    public function showAction($id){
        $em = $this->get('doctrine')->getManager();
        $fraccionar = $em->getRepository('NossisBundle:Fraccionar')->find($id);
        return $this->render('NossisBundle:Fraccionar:show.html.twig',
                array('fraccionar' => $fraccionar));
        
    }
    
}