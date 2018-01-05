<?php

namespace Nod4\RpsAdminBundle\Models;



class MpSlider extends A_Mp_Part
{


    public function setPartName()
    {
        $this->partName =basename( __CLASS__);
    }



    public function setContent()
    {
        $parts = $this->em->getRepository('RpsAdminBundle:MpContent')->findBy(array('part' => $this->partModel),array('id' =>'ASC'));

        foreach ($parts as $part) {
            $this->content[] = $this->em->getRepository('RpsAdminBundle:Content')->find($part->getContentId());
        }
        return $this;
    }

    public function setDefaultTemplate()
    {
        $this->defaultTemplate ="RpsBundle:MainPage:SliderTemplate.html.twig";
        return $this;
    }

}