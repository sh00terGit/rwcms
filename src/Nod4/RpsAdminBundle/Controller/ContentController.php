<?php

namespace Nod4\RpsAdminBundle\Controller;

use Nod4\RpsAdminBundle\Entity\Content;
use Nod4\RpsAdminBundle\Form\ContentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/content")
 */
class ContentController extends Controller
{

    /**
     * @Route("/", name="content_list")
     *
     */
    public function indexAction()
    {
        $this->datatable()->execute();

        return $this->render('RpsAdminBundle:Content:index.html.twig');
    }

    /**
     *
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function datatable()
    {

        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('cont','cat')
        ->from("RpsAdminBundle:Content", "cont")
            ->leftJoin('RpsAdminBundle:Category','cat','WITH' , 'cat.id = cont.category');


        $datatable = $this->get('datatable')
            ->setFields(
                array(
                    "Название" => 'cont.fname',
                    "Категория" => 'cat.fname',
                    " " => 'cont.id',
                    "" => 'cont.id',
                    "_identifier_" => 'cont.id'
            ))
            ->setRenderers(
                array(
                    2 => array(
                        'view' => 'RpsAdminBundle:Datatable:action_edit.html.twig', // Path to the template
                        'params' => array(
                            'edit_route' => 'content_edit',
                            'id' => 'cont.id',
                        ),
                    ),
                    3 => array(
                       'view' => 'RpsAdminBundle:Datatable:action_delete.html.twig', // Path to the template
                        'params' => array(
                            'id' => 'cont.id',
                        )
                    ),
                )
            );;

        $datatable->getQueryBuilder()->setDoctrineQueryBuilder($qb);

        return $datatable;

    }

    /**
     * Grid action
     * @Route("/dt", name="content_data")
     * @return Response
     */
    public function gridAction()
    {
        return $this->datatable()->execute();                                      // call the "execute" method in your grid action
    }

    /**
     * @Route("/edit/{id}",name="content_edit")
     * @ParamConverter("entity", options={"mapping": {"id": "id"}})
     *
     */
    public function editAction(Request $request, Content $entity)
    {


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',$entity->getSname().' cохранено успешно'
            );
            return $this->redirect($this->generateUrl('content_list'));
        }
        return $this->render('RpsAdminBundle:Content:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/new", name="content_new")
     *
     */
    public function newAction(Request $request)
    {
        $entity = new Content();
        $form = $this->createForm(new ContentType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',$entity->getSname().' cохранено успешно'
            );
            return $this->redirect($this->generateUrl('content_list'));
        }

        return $this->render('RpsAdminBundle:Content:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to edit a  entity.
     *
     * @param Content $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Content $entity)
    {
        $form = $this->createForm(new ContentType(), $entity);


        return $form;
    }


    /**
     * @param Request $request
     * @Route("/remove", name="content_remove")
     * @return Response
     */
    public function RemoveAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $enquiry = $em->getRepository('RpsAdminBundle:Content')->find($request->get('id'));

            $em->remove($enquiry);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',$enquiry->getSname().' успешно удалено'
            );
        }
        return new JsonResponse();
    }

}
