<?php

namespace Nossis\NossisBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
   
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav pull-right');
        
        $menu->addChild('Inicio', array ('route' => 'nossis_homepage'))->setAttribute('divider_prepend', true);
        
        $menu->addChild('Exportacion Alma', array ('route' => 'exportacionalma'))->setAttribute('divider_prepend', true);
        
        $menu->addChild('Listar')->setAttribute('dropdown', true)->setAttribute('divider_prepend', true);
        
        $menu['Listar']->addChild('Stock Actual', array('route' => 'listar_stock'));
        $menu['Listar']->addChild('Generales', array('route' => 'index_listado_general'));
        
        $menu->addChild('Administracion', array ('route' => 'sonata_admin_dashboard'))->setAttribute('divider_prepend', true);
        
        return $menu;
    }
    
}
