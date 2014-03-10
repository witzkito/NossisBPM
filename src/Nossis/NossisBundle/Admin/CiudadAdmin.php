<?php
namespace Nossis\NossisBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CiudadAdmin extends Admin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('codigopostal', 'text', array('label' => 'Codigo Postal'))
            ->add('provincia', 'text', array('label' => 'Provincia'))
            ->add('pais', 'entity', array('class' => 'Nossis\NossisBundle\Entity\Pais'))
            ->add('latitud')            
            ->add('longitud')            
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('provincia')
            ->add('pais')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('nombre')
            ->add('provincia')
            ->add('codigopostal')
            ->add('pais')
            ->add('latitud')
            ->add('longitud')
        ;
    }
    
}

?>
