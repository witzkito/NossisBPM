<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nossis\NossisBundle\Entity\EnvaseRetiro;
use Nossis\NossisBundle\Form\EnvaseRetiroType;

/**
 * EnvaseRetiro controller.
 *
 * @Route("/envase/retiro")
 */
class EnvaseRetiroController extends Controller
{

    /**
     * Lists all EnvaseRetiro entities.
     *
     * @Route("/index", name="envase_retiro")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NossisBundle:EnvaseRetiro')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new EnvaseRetiro entity.
     *
     * @Route("/crear", name="envase_retiro_create")
     * @Template("NossisBundle:EnvaseRetiro:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new EnvaseRetiro();
        $entity->setFecha(new \DateTime('NOW'));
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            if ($entity->getCantidad() > $entity->getEnvase()->getTotal()){
                $this->get('session')->getFlashBag()->add(
                            'notice',
                            'La cantidad a despachar es mayor a la cantidad actual'
                        );
            }else{
                $em->persist($entity);
                $em->flush();
                
                return $this->redirect($this->generateUrl('envase_ingreso_show', array('id' => $entity->getEnvase()->getId())));
            
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a EnvaseRetiro entity.
     *
     * @param EnvaseRetiro $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EnvaseRetiro $entity)
    {
        $form = $this->createForm(new EnvaseRetiroType(), $entity, array(
            'action' => $this->generateUrl('envase_retiro_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => 'btn btn-success')));

        return $form;
    }

    /**
     * Displays a form to create a new EnvaseRetiro entity.
     *
     * @Route("/new/{id}", name="envase_retiro_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('NossisBundle:Stock')->find($id);
        $entity = new EnvaseRetiro();
        $entity->setStock($stock);
        $entity->setFecha(new \DateTime('now'));
        
        $total = 0;
        foreach ($entity->getStock()->getEnvases() as $envases){
            $total = $total + $envases->getCantidad();
        }
        
        $entity->setCantidad($stock->getIngresado() - $total);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EnvaseRetiro entity.
     *
     * @Route("/mostrar/{id}", name="envase_retiro_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:EnvaseRetiro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnvaseRetiro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EnvaseRetiro entity.
     *
     * @Route("/{id}/edit", name="envase_retiro_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:EnvaseRetiro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnvaseRetiro entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a EnvaseRetiro entity.
    *
    * @param EnvaseRetiro $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EnvaseRetiro $entity)
    {
        $form = $this->createForm(new EnvaseRetiroType(), $entity, array(
            'action' => $this->generateUrl('envase_retiro_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing EnvaseRetiro entity.
     *
     * @Route("/{id}", name="envase_retiro_update")
     * @Method("PUT")
     * @Template("NossisBundle:EnvaseRetiro:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:EnvaseRetiro')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnvaseRetiro entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('envase_retiro_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EnvaseRetiro entity.
     *
     * @Route("/{id}", name="envase_retiro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NossisBundle:EnvaseRetiro')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EnvaseRetiro entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('envase_retiro'));
    }

    /**
     * Creates a form to delete a EnvaseRetiro entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('envase_retiro_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
