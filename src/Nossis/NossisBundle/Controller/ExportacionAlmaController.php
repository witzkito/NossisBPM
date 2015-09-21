<?php

namespace Nossis\NossisBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Nossis\NossisBundle\Entity\ExportacionAlma;
use Nossis\NossisBundle\Form\ExportacionAlmaType;
use Nossis\NossisBundle\Entity\ItemExportacionAlma;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


/**
 * ExportacionAlma controller.
 *
 * @Route("/exportacionalma")
 */
class ExportacionAlmaController extends Controller
{

    /**
     * Lists all ExportacionAlma entities.
     *
     * @Route("/", name="exportacionalma")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('NossisBundle:ExportacionAlma')->findBy(array(), array('id' => "DESC"));

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new ExportacionAlma entity.
     *
     * @Route("/", name="exportacionalma_create")
     * @Method("POST")
     * @Template("NossisBundle:ExportacionAlma:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new ExportacionAlma();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $entity->setAutomatico(false);
            $em->persist($entity);
            $productos = $this->generarArrayExportacion($entity->getFechaInicio(), $entity->getFechaFin());
            foreach($productos as $key => $prod)
            {
                $item = new ItemExportacionAlma;
                $item->setCantidad(($prod['ingresos'] + $prod['devolucion']) - ($prod['despachos'] + $prod['bajas']));
                $producto = $em->getRepository('NossisBundle:Producto')->find($key);
                $item->setCodigo($producto->getCodAlma());
                $item->setFechaFin($entity->getFechaFin());
                $item->setExportacion($entity);
                $em->persist($item);                
            }
            $em->flush();

            return $this->redirect($this->generateUrl('exportacionalma_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a ExportacionAlma entity.
     *
     * @param ExportacionAlma $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ExportacionAlma $entity)
    {
        $form = $this->createForm(new ExportacionAlmaType(), $entity, array(
            'action' => $this->generateUrl('exportacionalma_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new ExportacionAlma entity.
     *
     * @Route("/new", name="exportacionalma_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new ExportacionAlma();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a ExportacionAlma entity.
     *
     * @Route("/{id}", name="exportacionalma_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:ExportacionAlma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExportacionAlma entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing ExportacionAlma entity.
     *
     * @Route("/{id}/edit", name="exportacionalma_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:ExportacionAlma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExportacionAlma entity.');
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
    * Creates a form to edit a ExportacionAlma entity.
    *
    * @param ExportacionAlma $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ExportacionAlma $entity)
    {
        $form = $this->createForm(new ExportacionAlmaType(), $entity, array(
            'action' => $this->generateUrl('exportacionalma_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ExportacionAlma entity.
     *
     * @Route("/{id}", name="exportacionalma_update")
     * @Method("PUT")
     * @Template("NossisBundle:ExportacionAlma:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('NossisBundle:ExportacionAlma')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExportacionAlma entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('exportacionalma_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a ExportacionAlma entity.
     *
     * @Route("/{id}", name="exportacionalma_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('NossisBundle:ExportacionAlma')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExportacionAlma entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('exportacionalma'));
    }

    /**
     * Creates a form to delete a ExportacionAlma entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('exportacionalma_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    private function generarArrayExportacion($desde, $hasta)
    {
        $em = $this->get('doctrine')->getManager();
        $productos = $em->getRepository('NossisBundle:Producto')->findAll();
        $entities = array();
        foreach ($productos as $producto)
        {
            $entities[$producto->getId()]['ingresos'] = 0;
            $entities[$producto->getId()]['despachos'] = 0;
            $entities[$producto->getId()]['devolucion'] = 0;
            $entities[$producto->getId()]['bajas'] = 0;
            foreach ($producto->getStocks() as $stock)
            {
                if ($stock->getFechaIngreso() >= $desde && $stock->getFechaIngreso() <= $hasta)
                {
                    $entities[$producto->getId()]['ingresos'] = $entities[$producto->getId()]['ingresos'] + $stock->getIngresado();
                }
                foreach ($stock->getRetiros() as $retiro)
                {
                    if ($retiro->getRetiro()->getFechaSalida() >= $desde && $retiro->getRetiro()->getFechaSalida() <= $hasta)
                    {
                        $entities[$producto->getId()]['despachos'] = $entities[$producto->getId()]['despachos'] + $retiro->getCantidad();
                    }
                    foreach ($retiro->getDevoluciones() as $devolucion)
                    {
                        if ($devolucion->getFecha() >= $desde && $devolucion->getFecha() <= $hasta)
                        {
                            $entities[$producto->getId()]['devolucion'] = $entities[$producto->getId()]['devolucion'] + $devolucion->getCantidad();
                        }
                    }
                }
                foreach ($stock->getBajas() as $baja)
                {
                    if ($baja->getFecha() >= $desde && $baja->getFecha() <= $hasta)
                    {
                        $entities[$producto->getId()]['bajas'] = $entities[$producto->getId()]['bajas'] + $baja->getCantidad();
                    }
                }
                
            }
        }
        return $entities;
    }
    
    /**
     * Deletes a ExportacionAlma entity.
     *
     * @Route("/exportacion/{id}", name="exportacionalma_exportxls")
     */
    public function exportXlsAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $exportacion = $em->getRepository('NossisBundle:ExportacionAlma')->find($id);
        
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("witzkito@gmail.com")
           ->setLastModifiedBy("witzkito@gmail.com")
           ->setTitle("Exportacion NosssisBMP a Alma")
           ->setSubject("Exportacion NosssisBMP a Alma")
           ->setDescription("Planilla para importar los stock del NossisBMP a Alma")
           ->setKeywords("planilla xls NossisBMP Alma")
           ->setCategory("Exportacion");
       $phpExcelObject->setActiveSheetIndex(0)
           ->setCellValue('A1', 'Numero Planilla')
           ->setCellValue('B1', 'Fecha Hora')
           ->setCellValue('C1', 'Codigo Alma')
           ->setCellValue('D1', 'Cantidad');
       $phpExcelObject->getActiveSheet()->setTitle('Exportacion');
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $fila = 1;
       $phpExcelObject->setActiveSheetIndex(0)->setCellValue("B2", "HOLA");
       foreach ($exportacion->getItems() as $exp)
       {
           $fila = $fila + 1;
           $phpExcelObject->setActiveSheetIndex(0)->setCellValue("A".$fila, $exp->getExportacion()->getId())
                                                  ->setCellValue("B".$fila, $exp->getFechaFin()->format('m/d/Y'))
                                                  ->setCellValue("C".$fila, $exp->getCodigo())
                                                  ->setCellValue("D".$fila, $exp->getCantidad());
       }
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'exportacion-nossis-'. $exportacion->getId() .'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }
    
    /**
     * 
     *
     * @Route("/generar/automatico", name="exportacionalma_automatica")
     * @Template()
     */
    public function automaticaAction()
    {
        $em = $this->getDoctrine()->getManager();
        $exportacion = $em->getRepository('NossisBundle:ExportacionAlma')->findOneBy(array("automatico" => true), array('id' => 'DESC'));
        $fechaFin = new \DateTime("now");
        $productos = $this->generarArrayExportacion($exportacion->getFechaFin(), $fechaFin);
        $exp = new ExportacionAlma();
        $exp->setFechaFin($fechaFin);
        $exp->setFechaInicio($exportacion->getFechaFin());
        $exp->setAutomatico(true);
        $em->persist($exp);   
        foreach($productos as $key => $prod)
        {
            $item = new ItemExportacionAlma;
            $item->setCantidad(($prod['ingresos'] + $prod['devolucion']) - ($prod['despachos'] + $prod['bajas']));
            $producto = $em->getRepository('NossisBundle:Producto')->find($key);
            $item->setCodigo($producto->getCodAlma());
            $item->setFechaFin($fechaFin);
            $item->setExportacion($exp);
            $em->persist($item);
        }
        $em->flush();

        return $this->redirect($this->generateUrl('exportacionalma_exportxls', array('id' => $exp->getId())));
        

        
    }
}
