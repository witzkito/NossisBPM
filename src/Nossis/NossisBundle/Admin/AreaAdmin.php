<?php
namespace Nossis\NossisBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class AreaAdmin extends Admin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('salida', null, array('label' => "Salida"))
            ->add('destruccion',null, array('label' => "¿Area de Destruccion?"))
            ->add('capacidad', 'integer', array('label' => 'Capacidad'))
            ->add('almacen', 'entity', array('class' => 'Nossis\NossisBundle\Entity\Almacen'))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('salida')
            ->add('destruccion')
            ->add('capacidad')
            ->add('almacen')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('nombre')
            ->add('salida')                
            ->add('destruccion')
            ->add('capacidad')
            ->add('almacen')    
        ;
    }
    
}

?>
