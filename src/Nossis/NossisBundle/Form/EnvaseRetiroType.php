<?php

namespace Nossis\NossisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Nossis\NossisBundle\Entity\Repositorio\EnvaseIngresoRepository;

class EnvaseRetiroType extends AbstractType
{
    private $entity;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'genemu_jquerydate', array('widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
            ->add('cantidad')
            ->add('loteDestino')
            ->add('envase', 'entity', array('label' => 'Lote Envase', 'required' => true,
                            'class' => 'NossisBundle:EnvaseIngreso',
                            'query_builder' => function(EnvaseIngresoRepository $e){
                                return $e->createQueryBuilder('e')
                                        ->join('e.envase', 'en')
                                        ->leftjoin('e.retiros', 'r')
                                        ->groupBy('e')
                                        ->having('SUM(r.cantidad) < e.cantidad')
                                        ->orHaving('COUNT(r.cantidad) = 0')
                                        ->orderBy('en.identificador');
                            }
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Nossis\NossisBundle\Entity\EnvaseRetiro'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'nossis_nossisbundle_envaseretiro';
    }
    
    public function __construct($entity)
    {
    $this->entity = $entity;

    }
}
