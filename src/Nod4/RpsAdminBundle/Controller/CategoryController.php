<?php

namespace Nod4\RpsAdminBundle\Controller;

use Nod4\RpsAdminBundle\Entity\Category;
use Nod4\RpsAdminBundle\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/category")
 */
class CategoryController extends Controller
{

    /**
     * @Route("/", name="cat_list")
     *
     */
    public function indexAction()
    {
        $this->datatable()->execute();                                                         // call the datatable config initializer
        return $this->render('RpsAdminBundle:Category:index.html.twig');
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
            ->setEntity("Nod4\RpsAdminBundle\Entity\Category", "x")
            ->setFields(
                array(
                    "Название" => 'x.fname',
                    "" => 'x.id',
                    " " => 'x.id',
                    "_identifier_" => 'x.id')                          // you have to put the identifier field without label. Do not replace the "_identifier_"
            )
            ->setRenderers(
                array(
                    1 => array(
                        'view' => 'RpsAdminBundle:Datatable:action_edit.html.twig', // Path to the template
                        'params' => array(
                            'edit_route' => 'cat_edit',
                            'id' => 'cat.id',
                        ),
                    ),
                    2 => array(
                        'view' => 'RpsAdminBundle:Datatable:action_delete.html.twig', // Path to the template
                        'params' => array(
                            'id' => 'cat.id',
                        ),
                    ),
                )
            );
        return $datatable;

    }

    /**
     * Grid action
     * @Route("/dt", name="cat_data")
     * @return Response
     */
    public function gridAction()
    {
        return $this->datatable()->execute();                                      // call the "execute" method in your grid action
    }

    /**
     * @Route("/edit/{id}",name="cat_edit")
     * @ParamConverter("entity", options={"mapping": {"id": "id"}})
     *
     */
    public function editAction(Request $request, Category $entity)
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
            return $this->redirect($this->generateUrl('cat_list'));

        }
        return $this->render('RpsAdminBundle:Category:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/new", name="cat_new")
     *
     */
    public function newAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createForm(new CategoryType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('cat_list'));
        }

        return $this->render('RpsAdminBundle:Category:new.html.twig', array(
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
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity);


        return $form;
    }


    /**
     * @param Request $request
     * @Route("/remove", name="cat_remove")
     * @return Response
     */
    public function RemoveAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $enquiry = $em->getRepository('RpsAdminBundle:Category')->find($request->get('id'));

            $em->remove($enquiry);
            $em->flush();
        }
        return new Response('deleted');
    }

}
