<?php
/**
 * Created by PhpStorm.
 * User: ivc_shipul
 * Date: 21.12.2017
 * Time: 13:29
 */

namespace Nod4\RpsAdminBundle\Models;


class MpLine extends A_Mp_Part
{

    public function setPartName()
    {
        $this->partName =basename( __CLASS__);
    }

    public function setDefaultTemplate()
    {
        $this->defaultTemplate = "RpsBundle:MainPage:LineTemplate.html.twig";
    }

    public function setContent()
    {
        $parts = $this->em->getRepository('RpsAdminBundle:MpContent')->findBy(array('part' => $this->partModel),array('id' =>'ASC'));

        foreach ($parts as $part) {
            $this->content[] = $this->em->getRepository('RpsAdminBundle:Content')->find($part->getContentId());
        }
        return $this;
    }

}