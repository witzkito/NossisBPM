<?php

namespace Nossis\NossisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DestruccionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'genemu_jquerydate', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
            ->add('motivo')
            ->add('cantidad')
            ->add('stock')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nossis\NossisBundle\Entity\Destruccion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nossis_nossisbundle_destruccion';
    }
}
