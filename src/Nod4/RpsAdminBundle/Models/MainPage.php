<?php
/**
 * Created by PhpStorm.
 * User: ivc_shipul
 * Date: 21.12.2017
 * Time: 13:22
 */

namespace Nod4\RpsAdminBundle\Models;
use Symfony\Component\DependencyInjection\ContainerInterface;


class MainPage
{

    public $partsMp = array();
    /**
     * @var ContainerInterface
     */
    public $container;
    public $twig;
    public  $fullTemplate;
    public $em;


    /**
     * MainPage constructor.
     * @param ContainerInterface $containerAware
     */
    public function __construct(ContainerInterface $containerAware)
    {
        $this->container = $containerAware;
        $this->em = $this->container->get('doctrine.orm.default_entity_manager');
        $this->twig = $this->container->get('twig');
        $this->addPart(new MpSlider( $this->container));
        $this->addPart(new MpBar( $this->container));
        $this->addPart(new MpLine( $this->container));
    }





    public function renderTemplate(A_Mp_Part $mpPart){
         return $this->twig->render($mpPart->getTemplate(),array(
            'object' =>$mpPart)
        );
    }

    public function getView(){
        foreach ($this->partsMp as $part) {
          $this->fullTemplate.=$this->renderTemplate($part);
        }
        return $this->fullTemplate;
    }


    public function getParts() {
        return $this->partsMp;
    }

    public function addPart(A_Mp_Part $part) {
        if($part->getStatus()) {
            $this->partsMp[ $part->getPriority() ] = $part;
            ksort($this->partsMp);
        }
    }


}