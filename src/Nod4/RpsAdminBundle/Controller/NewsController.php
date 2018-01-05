<?php

namespace Nod4\RpsAdminBundle\Controller;

use Nod4\RpsAdminBundle\Entity\News;
use Nod4\RpsAdminBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/news")
 */
class NewsController extends Controller
{

    /**
     * @Route("/", name="news_list")
     *
     */
    public function indexAction()
    {
        $this->datatable()->execute();                                                         // call the datatable config initializer
        return $this->render('RpsAdminBundle:News:index.html.twig');
    }

    /**
     *
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function datatable()
    {
        $datatable = $this->get('datatable');
        $datatable
            ->setEntity("Nod4\RpsAdminBundle\Entity\News", "x")
            ->setFields(
                array(

                    "Новость" => 'x.title',
                    "Дата" => 'x.date',
                    "" => 'x.id',
                    " " => 'x.id',
                    "_identifier_" => 'x.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
            )
            ->setRenderers(
                array(
                    1 => array(
                        'view' => 'RpsAdminBundle:Datatable:field_date.html.twig',
                    ),
                    2 => array(
                        'view' => 'RpsAdminBundle:Datatable:action_edit.html.twig', // Path to the template
                        'params' => array(
                            'edit_route' => 'news_edit',
                        ),
                    ),
                    3 => array(
                        'view' => 'RpsAdminBundle:Datatable:action_delete.html.twig', // Path to the template
                    ),
                )
            );
        return $datatable;

    }

    /**
     * Grid action
     * @Route("/dt", name="datatable")
     * @return Response
     */
    public function gridAction()
    {
        return $this->datatable()->execute();                                      // call the "execute" method in your grid action
    }

    /**
     * @Route("/edit/{id}",name="news_edit")
     * @ParamConverter("entity", options={"mapping": {"id": "id"}})
     * @Template()
     */
    public function editAction(Request $request, News $entity)
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
            $this->get('session')->getFlashBag()->add('notice', 'Сохранено успешно!');

        }
        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        );
    }

    /**
     * @Route("/new", name="news_new")
     *
     */
    public function newAction(Request $request)
    {
        $entity = new News();
        $form = $this->createForm(new NewsType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('news_list'));
        }

        return $this->render('RpsAdminBundle:News:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to edit a  entity.
     *
     * @param InfoContent $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(News $entity)
    {
        $form = $this->createForm(new NewsType(), $entity);


        return $form;
    }


    /**
     * @param Request $request
     * @Route("/newsremove", name="news_remove")
     * @return Response
     */
    public function newsRemoveAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $enquiry = $em->getRepository('RpsAdminBundle:News')->find($request->get('id'));

            $em->remove($enquiry);
            $em->flush();
        }
        return new Response('deleted');
    }

}
