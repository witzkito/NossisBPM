<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nossis\NossisBundle\Entity\Destruccion;
use Nossis\NossisBundle\Form\DestruccionType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Nossis\NossisBundle\Entity\EstadoStock;

/**
 * Destruccion controller.
 *
 * @Route("/destruccion")
 */
class DestruccionController extends Controller
{
    /**
     * @Route("/new/{id}", name="destruccion_new")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        $destruccion = new Destruccion;
        $destruccion->setFecha(new \DateTime('NOW'));
        $destruccion->setStock($stock);
        $destruccion->setCantidad($stock->getActual());
        $form = $this->createForm(new DestruccionType(), $destruccion);
        return array("entity" => $destruccion, "form" => $form->createView()
                // ...
            );        
    }
    
    /**
     * @Route("/create", name="destruccion_crear")
     */
    public function crearAction(Request $request)
    {
        $destruccion = new Destruccion();
        $form = $this->createForm(new DestruccionType(), $destruccion);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $destruccion = $form->getData();
            $estadoStock = new EstadoStock;
            $estadoStock->setStock($destruccion->getStock());
            $estadoStock->setEstado('Destruido');
            $estadoStock->setDescripcion($destruccion->getCantidad() . " unidades del producto fueron destruido por " . $destruccion->getMotivo());
            $estadoStock->setFecha(new \DateTime('now'));

            $destruccion->getStock()->retirar($destruccion->getCantidad());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($estadoStock);
            $em->persist($destruccion);
            $em->persist($destruccion->getStock());
            $em->flush();
            return new RedirectResponse($this->generateUrl('show_stock', array("id" => $destruccion->getStock()->getId())));
        }
    }
}
