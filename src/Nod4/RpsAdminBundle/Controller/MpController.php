<?php

namespace Nod4\RpsAdminBundle\Controller;

use Nod4\RpsAdminBundle\Entity\MpPart;
use Nod4\RpsAdminBundle\Form\MpPartType;
use Nod4\RpsAdminBundle\Form\MpPart2Type;
use Nod4\RpsAdminBundle\Form\MpPart3Type;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class MpController
 * @package Nod4\RpsAdminBundle\Controller
 * @Route("/mp")
 */
class MpController extends Controller
{

    /**
     * @Route("/mpView", name="mp_view")
     *
     */
    public function indexAction()
    {
        $em=$this->getDoctrine()->getEntityManager();
        $mpPartSlider = $em->getRepository('RpsAdminBundle:MpPart')->findOneBy(array('partName' =>'MpSlider'));
        $mpPartBar = $em->getRepository('RpsAdminBundle:MpPart')->findOneBy(array('partName' =>'MpBar'));
        $mpPartLine = $em->getRepository('RpsAdminBundle:MpPart')->findOneBy(array('partName' =>'MpLine'));

        $form = $this->createForm(new MpPartType(), $mpPartSlider, array(
        'action' => $this->generateUrl('mp_edit',array('id' => $mpPartSlider->getId())),
        ));

        $form2 = $this->createForm(new MpPart2Type(), $mpPartBar, array(
            'action' => $this->generateUrl('mp_edit',array('id' => $mpPartBar->getId())),

        ));

        $form3 = $this->createForm(new MpPart3Type(), $mpPartLine, array(
            'action' => $this->generateUrl('mp_edit',array('id' => $mpPartLine->getId())),
        ));
        $mpParts =  $em->getRepository('RpsAdminBundle:MpPart')->findBy(array(),array('priority' => 'ASC'));

        return $this->render('RpsAdminBundle:Mp:mpView.html.twig',array(
            'form' =>  $form->createView(), 'form2' =>  $form2->createView(), 'form3' =>  $form3->createView(),
            'mpParts' => $mpParts
        ));
    }


    /**
     * @param Request $request
     * @param MpPart $entity
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/mpEdit/{id}", name="mp_edit")
     */
    public function handlerAction(Request $request,MpPart $entity ) {
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity MpPart.');
        }
        switch ($entity->getPartName()){
            case "MpSlider" :
                $form = $this->createForm(new MpPartType(), $entity);

                break;
            case "MpBar" :
                $form = $this->createForm(new MpPart2Type(), $entity);

                break;
            case "MpLine" :
                $form = $this->createForm(new MpPart3Type(), $entity);

                break;
        }
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isValid() ) {
            $em->persist($entity);
            $em->flush();
        }
        return $this->redirect($this->generateUrl('mp_view'));
    }

}



