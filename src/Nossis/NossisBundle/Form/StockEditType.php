<?php

namespace Nossis\NossisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StockEditType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producto', 'genemu_jqueryselect2_entity', array(
                "class" => "Nossis\NossisBundle\Entity\Producto",
                'label' => 'Producto'))
            ->add('lote')
            ->add('fechaEnvasado', 'genemu_jquerydate', array(
                'widget' => 'single_text'
            ))
            ->add('palet')
            ->add('turno','choice', array(
                    'choices'   => array(
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        '0' => 'SIN TURNO'),
                    'required'  => true,
                ))
            ->add('ingresado', 'integer', array(
                    'label'     => 'Stock Ingresado'
            ))
            ->add('actual', 'integer', array(
                    'label'     => 'Stock Actual'
            ))
            ->add('motivoEdicion', 'textarea', array(
                    'label'     => 'Motivo de la Edicion'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nossis\NossisBundle\Entity\Stock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nossis_nossisbundle_stock';
    }
}
