<?php

namespace Nod4\RpsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @package Nod4\RpsBundle\Controller
 * @Route("/content")
 */
class ContentController extends Controller
{

    /**
     * @Route("/{id}", name="content_view")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function RenderMenuAction($id){
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('RpsAdminBundle:Content')->find($id);
        return $this->render('RpsBundle:Content:ContentView.html.twig' , array(
            'content' => $content
        ));

    }


}
