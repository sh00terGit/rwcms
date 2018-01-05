<?php

namespace Nod4\RpsAdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Knp\Menu\ItemInterface;

class Builder extends ContainerAware {

    public function AdminTopMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        $menu->addChild('Профиль', array(
            'uri' => '#',
            'attributes' => array('class' => 'dropdown'),
            'label' => 'Профиль <span class="caret"></span>',
            'extras' => array('safe_label' => true))
        );

        $menu['Профиль']->setLinkAttributes(array('class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
        $menu['Профиль']->setChildrenAttributes(array('class' => 'dropdown-menu'));

        $menu['Профиль']->addChild('Редактировать', array('route' => 'fos_user_profile_edit'));
        $menu['Профиль']->addChild('Просмотр', array('route' => 'fos_user_profile_show'));
        $menu['Профиль']->addChild(NULL, array('attributes' => array('class' => 'divider')));
        $menu['Профиль']->addChild('Выйти', array('route' => 'fos_user_security_logout'));
        
        
        
        return $menu;
    }
    
    public function AdminLeftMenu(FactoryInterface $factory, array $options) {
         $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav nav-sidebar');
         
         
         $menu->addChild("Новости", array(
             'route' => 'news_list',
             'attributes' => array('class' => 'bg-info h4')
             ));
         
          $menu->addChild("Статистика", array(
             'route' => 'news_list',
             'attributes' => array('class' => 'bg-info h4')
             ));
         
         
         return $menu;
    }
}