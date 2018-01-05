<?php

namespace Nod4\RpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package Nod4\RpsBundle\Controller
 */
class MenuController extends Controller
{


    /** Рисует меню , рекурсивно
     * @param null $parent
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RenderMenuAction($parent = NULL)
    {
        $em = $this->getDoctrine()->getManager();
        /*$sections = $em->getRepository('RpsAdminBundle:Section')->findBy(array(
            'parent' => $parent,
        ));*/
        $sections = $em->getRepository('RpsAdminBundle:Section')->getOrderedByParent($parent);

        return $this->render('RpsBundle:Menu:Menu.html.twig', array('sections' => $sections));

    }


}
