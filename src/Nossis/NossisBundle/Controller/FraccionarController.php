<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Nossis\NossisBundle\Form\FraccionarType;
use Nossis\NossisBundle\Entity\Fraccionar;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Nossis\NossisBundle\Entity\EstadoStock;
use APY\DataGridBundle\Grid\Source\Entity;
use APY\DataGridBundle\Grid\Action\RowAction;
use Symfony\Component\Form\FormError;

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
                
                if ($fraccionar->getCantidad() <= $stock->getActual())
                {
                    $fraccionar->setFecha(new \DateTime('now'));

                    $stock->retirarStock($fraccionar->getCantidad());

                    $estadoStock = new EstadoStock;
                    $estadoStock->setEstado("Fraccionado");
                    $estadoStock->setStock($stock);
                    $estadoStock->setDescripcion("Se retiro la cantidad de ". $fraccionar->getCantidad() ." unidades para fraccionado");
                    $estadoStock->setFecha(new \DateTime('NOW'));

                    $em->persist($fraccionar);
                    $em->persist($stock);
                    $em->persist($estadoStock);
                    $em->flush();
                    return new RedirectResponse($this->generateUrl('show_stock',array('id' => $stock->getId())));
                }else{
                     $form = $this->get('form.factory')->create(
                        new FraccionarType(),
                        $fraccionar
                     );
                    $form->get('cantidad')->addError(new FormError('No hay Suficiente Stock'));
                }                
            }
        return $this->render('NossisBundle:Fraccionar:index.html.twig',
                array('fraccionar' => $fraccionar, 'form' => $form->createView()));     
    }
    
    public function showAction($id){
        $em = $this->get('doctrine')->getManager();
        $fraccionar = $em->getRepository('NossisBundle:Fraccionar')->find($id);
        $destinos = $em->getRepository('NossisBundle:Stock')->findBy(array('lote' => $fraccionar->getLoteDestino()));
        return $this->render('NossisBundle:Fraccionar:show.html.twig',
                array('fraccionar' => $fraccionar, 'destinos' => $destinos));
        
    }
    
    public function listarAction(){
        $source = new Entity('NossisBundle:Fraccionar');
        $grid = $this->get('grid');
        
        $ver = new RowAction('Ver', 'show_fraccionar');
        $ver->setRouteParametersMapping(array('fraccionar.id' => 'id'));
        $grid->addRowAction($ver);
        /*$editar = new RowAction('Editar', 'editar_stock');
        $editar->setRouteParametersMapping(array('stock.id' => 'id'));
        $grid->addRowAction($editar);
        $imprimir = new RowAction('Imprimir', 'imprimir_stock');
        $imprimir->setRouteParametersMapping(array('stock.id' => 'id'));
        $grid->addRowAction($imprimir);*/

        $grid->setSource($source);
        $grid->setDefaultOrder('id', 'desc');
        return $grid->getGridResponse('NossisBundle:Fraccionar:listar.html.twig');
    }
    
    public function loteAction($id){
        $em = $this->get('doctrine')->getManager();
        $fraccionar = $em->getRepository('NossisBundle:Fraccionar')->find($id);
        $form = $this->createFormBuilder();
        $form->add('lote', 'text', array('required' => true, 'label' => 'Lote Destino'));
        $form = $form->getForm();
        $request = $this->get('request');
            if ($request->getMethod() == 'POST'){
                $form->bind($request);
                $datos = $form->getData();
                $fraccionar->setLoteDestino($datos['lote']);
                $em->persist($fraccionar);
                $em->flush();
                return new RedirectResponse($this->generateUrl('show_stock',array('id' => $fraccionar->getStock()->getId())));
            }
        return $this->render('NossisBundle:Fraccionar:lote.html.twig',
                array('fraccionar' => $fraccionar, 'form' => $form->createView()));     
    }
    
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $fraccionado = $em->getRepository("NossisBundle:Fraccionar")->find($id);
        if ($fraccionado != null)
        {
            $estadoStock = new EstadoStock;
            $estadoStock->setEstado("Fraccionado");
            $estadoStock->setStock($fraccionado->getStock());
            $estadoStock->setDescripcion("Se elimino el fraccionado de " . $fraccionado->getCantidad() . " unidades");
            $estadoStock->setFecha(new \DateTime('NOW'));
            
            $stock = $fraccionado->getStock();
            $stock->devolver($fraccionado->getCantidad());
            
            $em->persist($estadoStock);
            $em->remove($fraccionado);
            $em->persist($stock);
            $em->flush();
        }
        return new RedirectResponse($this->generateUrl('show_stock', array('id' => $stock->getId())));
    }
    
}
