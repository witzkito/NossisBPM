<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Entity\Retiro;
use Nossis\NossisBundle\Form\RetiroType;
use Nossis\NossisBundle\Entity\RetiroStock;
use Symfony\Component\HttpFoundation\Response;

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
                        $retirostock = new RetiroStock;
                        $retirostock->setStock($stock);
                        $retirostock->setRetiro($retiro);
                        $retirostock->setCantidad($stock->getCantidad());
                        $retiro->addStock($retirostock);
                    }
                    $em = $this->get('doctrine')->getManager();
                    $em->persist($retiro);
                    $em->flush();
                }
            }
              return $this->render('NossisBundle:Retiro:edit.html.twig',
                array('form' => $form->createView(), "retiro" => $em->getRepository('NossisBundle:Retiro')->find($id),
                    "stocks" => $em->getRepository('NossisBundle:RetiroStock')->findby(array("retiro" => $id)) ));
         
        }
            
    }
    
    /**
    *@Pdf(stylesheet="NossisBundle:Retiro:comprobantestyle.xml")
    */
    public function imprimirAction($retiro){
        $em = $this->get('doctrine')->getManager();
        $stocks = $em->getRepository('NossisBundle:RetiroStock')->findby(array("retiro" => $retiro->getId()));
        
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('NossisBundle:Retiro:comprobante.pdf.twig', array("retiro" => $retiro, "stocks" => $stocks), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
        /*$format = $this->get('request')->get('_format');
        
        return $this->render(sprintf('NossisBundle:Retiro:comprobante.pdf.twig', $format), array(
            'retiro' => $retiro, 'stocks' => $stocks
        ));*/
        
    }
    
   
}
