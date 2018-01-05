<?php
/**
 * Created by PhpStorm.
 * User: ivc_shipul
 * Date: 21.12.2017
 * Time: 13:29
 */

namespace Nod4\RpsAdminBundle\Models;



class MpBar extends A_Mp_Part
{


    public function setPartName()
    {
        $this->partName =basename( __CLASS__);
    }


    public function setContent()
    {
        $parts = $this->em->getRepository('RpsAdminBundle:MpContent')->findBy(array('part' => $this->partModel),array('id' =>'ASC'));

        foreach ($parts as $part) {
            if($part->getContentId())
                $this->content[] = $this->em->getRepository('RpsAdminBundle:Content')->find($part->getContentId());
            if($part->getCategoryId()) {

                $categoryContent = $this->em->getRepository('RpsAdminBundle:Content')
                        ->findBy(array(
                            'category' => $part->getCategoryId()
                        ),array('dateCreate' => 'DESC'),3);

                $this->content = array_merge($categoryContent,$this->content);
            }
        }
        return $this;
    }



    public function setDefaultTemplate()
    {
        $this->defaultTemplate = "RpsBundle:MainPage:BarTemplate.html.twig";
    }


}