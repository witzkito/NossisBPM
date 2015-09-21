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
        
        $menu->addChild('Listar')->setAttribute('dropdown', true)->setAttribute('divider_prepend', true);
        
        $menu['Listar']->addChild('Ingresos', array('route' => 'listar_ingreso_stock'));
        $menu['Listar']->addChild('Stock Actual', array('route' => 'listar_stock'));
        $menu['Listar']->addChild('Fraccionados', array('route' => 'listar_fraccionar'));
        $menu['Listar']->addChild('Despachos', array('route' => 'list_retiro'));
        $menu['Listar']->addChild('Generales', array('route' => 'index_listado_general'));
        
        return $menu;
    }
    
}
