<?php

namespace Nossis\NossisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RetiroType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaSalida')
            ->add('nroOrden')
            ->add('patente')
            ->add('stocks')
            ->add('transportista', 'genemu_jqueryselect2_entity', array(
                "class" => "Nossis\NossisBundle\Entity\Transportista",
                'label' => 'Transportista'))
            ->add('cliente', 'genemu_jqueryselect2_entity', array(
                "class" => "Nossis\NossisBundle\Entity\Cliente",
                'label' => 'Cliente'))
            ->add('empresa','genemu_jqueryselect2_entity', array(
                "class" => "Nossis\NossisBundle\Entity\Empresa",
                'label' => 'Empresa'))
            ->add('codigo', 'text', array(
                "label" => false,
                "required" => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nossis\NossisBundle\Entity\Retiro'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nossis_nossisbundle_retiro';
    }
}
