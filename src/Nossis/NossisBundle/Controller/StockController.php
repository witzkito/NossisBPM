<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Entity\Stock;
use Nossis\NossisBundle\Form\StockType;
use Symfony\Component\HttpFoundation\Response;
use Nossis\NossisBundle\Entity\Trazlado;
use Nossis\NossisBundle\Form\TrazladoType;
use \DateTime;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;

class StockController extends Controller
{
    public function ingresarAction($nuevo = false)
    {
         $em = $this->get('doctrine')->getManager();
         $stock = new Stock;
         $form = $this->get('form.factory')->create(
                new StockType(),
                $stock
         );
         $ultimosStock = $em->getRepository('NossisBundle:Stock')->findLast();
         
         return $this->render('NossisBundle:Stock:ingresar.html.twig',
                array( 'form' => $form->createView(), 'ultimos' => $ultimosStock,
                    'first' => $nuevo
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
            $stock->setActual($stock->getIngresado());
            $em = $this->get('doctrine')->getManager();
            $em->persist($stock);
            $em->flush();
            $stock->setCodigo($stock->getProducto()->getCodigo() . $stock->getId());
            $em->persist($stock);
            $em->flush();
            
           
            return $this->ingresarAction(true); 
                
        }
    }
    
    public function indexAction(){
        $form = $this->createFormBuilder()
            ->add('codigo')
            ->getForm();
        $request = $this->get('request');
        $form->bind($request);
        $datos = $form->getData();
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->findOneBy(array('codigo' => $datos['codigo']));
        if ($stock == null){
            return $this->redirect($this->generateUrl('nossis_homepage'));
        }else{
            return $this->render('NossisBundle:Stock:show.html.twig',
                array( 'form' => $form->createView(), 'stock' => $stock)); 
        }
             
        
    }
    
    public function trazladarAction($id){
        $em = $this->get('doctrine')->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        $trazlado = new Trazlado;
        $form = $this->get('form.factory')->create(
                new TrazladoType(),
                $trazlado
         );
        $request = $this->get('request');
        $form->bind($request);
        if ($form->isValid()){
            $trazlado = $form->getData();
            $stock->setArea($trazlado->getArea());
            $trazlado->setFecha(new DateTime('now'));
            $trazlado->setStock($stock);
            $em->persist($trazlado);
            $em->persist($stock);
            $em->flush();
            return $this->render('NossisBundle:Stock:show.html.twig',
                array( 'form' => $form->createView(), 'stock' => $stock));
        }
        return $this->render('NossisBundle:Stock:trazladar.html.twig',
                array( 'form' => $form->createView(), 'stock' => $stock));
    }
    
    public function listarAction(){
        $source = new Entity('NossisBundle:Stock');

        /* @var $grid \APY\DataGridBundle\Grid\Grid */
        $grid = $this->get('grid');
        
        /*$ver = new RowAction('Ver', 'show_stock');
        $ver->setRouteParametersMapping(array('stock.id' => 'id'));
        $grid->addRowAction($ver);
        $editar = new RowAction('Editar', 'edit_retiro');
        $editar->setRouteParametersMapping(array('retiro.id' => 'id'));
        $grid->addRowAction($editar);*/

        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'desc');
        return $grid->getGridResponse('NossisBundle:Stock:listar.html.twig');
    }

}
