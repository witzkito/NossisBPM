<?php
namespace Nossis\NossisBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class EmpresaAdmin extends Admin {
    
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre', 'text', array('label' => 'Nombre'))
            ->add('direccion', 'text', array('label' => 'Direccion'))
            ->add('telefono', 'text', array('label' => 'Telefono'))
            ->add('ciudad', 'entity', array('class' => 'Nossis\NossisBundle\Entity\Ciudad'))
        ;
    }
    
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nombre')
            ->add('direccion')        
            ->add('telefono');
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('nombre')
            ->add('direccion')
            ->add('telefono')
            ->add('ciudad')
        ;
    }
    
}

?>
