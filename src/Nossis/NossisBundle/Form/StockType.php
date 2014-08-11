<?php

namespace Nossis\NossisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StockType extends AbstractType
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
                    'choices'   => array('A' => 'A', 'B' => 'B', 'C' => 'C'),
                    'required'  => true,
                ))
            ->add('ingresado')
            ->add('area', 'genemu_jqueryselect2_entity', array(
                "class" => "Nossis\NossisBundle\Entity\Area",
                'label' => 'Area'))
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
