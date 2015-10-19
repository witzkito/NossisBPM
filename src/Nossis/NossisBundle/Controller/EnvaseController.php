<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nossis\NossisBundle\Entity\Envase;
use Nossis\NossisBundle\Form\EnvaseType;

/**
 * Envase controller.
 *
 * @Route("/envase")
 */
class EnvaseController extends Controller
{

    /**
     * Lists all Envase entities.
     *
     * @Route("/", name="envase")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NossisBundle:Envase')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Envase entity.
     *
     * @Route("/", name="envase_create")
     * @Method("POST")
     * @Template("NossisBundle:Envase:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Envase();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('envase_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Envase entity.
     *
     * @param Envase $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Envase $entity)
    {
        $form = $this->createForm(new EnvaseType(), $entity, array(
            'action' => $this->generateUrl('envase_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Envase entity.
     *
     * @Route("/new", name="envase_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Envase();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Envase entity.
     *
     * @Route("/{id}", name="envase_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:Envase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Envase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Envase entity.
     *
     * @Route("/{id}/edit", name="envase_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:Envase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Envase entity.');
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
    * Creates a form to edit a Envase entity.
    *
    * @param Envase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Envase $entity)
    {
        $form = $this->createForm(new EnvaseType(), $entity, array(
            'action' => $this->generateUrl('envase_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Envase entity.
     *
     * @Route("/{id}", name="envase_update")
     * @Method("PUT")
     * @Template("NossisBundle:Envase:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:Envase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Envase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('envase_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Envase entity.
     *
     * @Route("/{id}", name="envase_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NossisBundle:Envase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Envase entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('envase'));
    }

    /**
     * Creates a form to delete a Envase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('envase_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
