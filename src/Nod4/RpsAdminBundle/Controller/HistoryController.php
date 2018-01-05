<?php
/**
 * Created by PhpStorm.
 * User: ivc_shipul
 * Date: 13.12.2017
 * Time: 10:46
 */

namespace Nod4\RpsAdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/history")
 */
class HistoryController extends Controller
{

    /**
     * @Route("/", name="history_view")
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $content = $em->getRepository('RpsAdminBundle:History')->fetchWithPercents();

        return $this->render('RpsAdminBundle:History:index.html.twig',array(
            'history' => $content
        ));
    }

}