<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nossis\NossisBundle\Entity\EnvaseIngreso;
use Nossis\NossisBundle\Form\EnvaseIngresoType;

/**
 * EnvaseIngreso controller.
 *
 * @Route("/envase/ingreso")
 */
class EnvaseIngresoController extends Controller
{

    /**
     * Lists all EnvaseIngreso entities.
     *
     * @Route("/listar/{id}", name="envase_ingreso")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NossisBundle:EnvaseIngreso')->findBy(array('envase' => $id));
        $envase = $em->getRepository('NossisBundle:Envase')->find($id);
        return array(
            'entities' => $entities, 'envase' => $envase
        );
    }
    /**
     * Creates a new EnvaseIngreso entity.
     *
     * @Route("/nuevo", name="envase_ingreso_create")
     * @Method("POST")
     * @Template("NossisBundle:EnvaseIngreso:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new EnvaseIngreso();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('envase_ingreso', array('id' => $entity->getEnvase()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a EnvaseIngreso entity.
     *
     * @param EnvaseIngreso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(EnvaseIngreso $entity)
    {
        $form = $this->createForm(new EnvaseIngresoType(), $entity, array(
            'action' => $this->generateUrl('envase_ingreso_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ingresar', 'attr' => array('class' => "btn btn-success")));

        return $form;
    }

    /**
     * Displays a form to create a new EnvaseIngreso entity.
     *
     * @Route("/new/{id}", name="envase_ingreso_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $envase = $em->getRepository("NossisBundle:Envase")->find($id);
        $entity = new EnvaseIngreso();
        $entity->setEnvase($envase);
        $entity->setFecha(new \DateTime('NOW'));
        
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a EnvaseIngreso entity.
     *
     * @Route("/{id}", name="envase_ingreso_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:EnvaseIngreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnvaseIngreso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing EnvaseIngreso entity.
     *
     * @Route("/{id}/edit", name="envase_ingreso_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:EnvaseIngreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnvaseIngreso entity.');
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
    * Creates a form to edit a EnvaseIngreso entity.
    *
    * @param EnvaseIngreso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(EnvaseIngreso $entity)
    {
        $form = $this->createForm(new EnvaseIngresoType(), $entity, array(
            'action' => $this->generateUrl('envase_ingreso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar', 'attr' => array('class' => "btn btn-success")));

        return $form;
    }
    /**
     * Edits an existing EnvaseIngreso entity.
     *
     * @Route("/{id}", name="envase_ingreso_update")
     * @Method("PUT")
     * @Template("NossisBundle:EnvaseIngreso:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:EnvaseIngreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find EnvaseIngreso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('envase_ingreso_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a EnvaseIngreso entity.
     *
     * @Route("/{id}", name="envase_ingreso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NossisBundle:EnvaseIngreso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find EnvaseIngreso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('envase_ingreso'));
    }

    /**
     * Creates a form to delete a EnvaseIngreso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('envase_ingreso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
