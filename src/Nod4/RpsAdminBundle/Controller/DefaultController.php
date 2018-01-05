<?php

namespace Nod4\RpsAdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="admin_homepage")
     *
     */
    public function indexAction()
    {
        return $this->render('RpsAdminBundle:Default:index.html.twig');
    }


}
