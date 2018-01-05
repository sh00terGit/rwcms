<?php

namespace Nod4\RpsAdminBundle\Controller;

use Nod4\RpsAdminBundle\Entity\Section;
use Nod4\RpsAdminBundle\Form\SectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/section")
 */
class SectionController extends Controller
{

    /**
     * @Route("/", name="sec_list")
     *
     */
    public function indexAction()
    {
        $this->datatable()->execute();                                                         // call the datatable config initializer
        return $this->render('RpsAdminBundle:Section:index.html.twig');
    }

    /**
     *
     * set datatable configs
     * @return \Waldo\DatatableBundle\Util\Datatable
     */
    private function datatable()
    {
        $qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();
        $qb->select('sec')
            ->addSelect('parent')
            ->from("RpsAdminBundle:Section", "sec")
            ->leftJoin('RpsAdminBundle:Section','parent','WITH' , 'parent.id = sec.parent')
            ->orderBy('parend.id','DESC');


        $datatable = $this->get('datatable')
            ->setFields(
                array(
                    "Раздел" => 'parent.fname',
                    "Подраздел" => 'sec.fname',
                    " " => 'sec.id',
                    "" => 'sec.id',
                    "_identifier_" => 'sec.id',

                ))
            ->setRenderers(
                array(
                    2 => array(
                        'view' => 'RpsAdminBundle:Datatable:action_edit.html.twig', // Path to the template
                        'params' => array(
                            'edit_route' => 'sec_edit',
                        ),
                    ),
                    3 => array(
                        'view' => 'RpsAdminBundle:Datatable:action_delete.html.twig', // Path to the template
                    ),
                )
            );

        $datatable->getQueryBuilder()->setDoctrineQueryBuilder($qb);

        return $datatable;

    }

    /**
     * Grid action
     * @Route("/dt", name="sec_data")
     * @return Response
     */
    public function gridAction()
    {
        return $this->datatable()->execute();                                      // call the "execute" method in your grid action
    }

    /**
     * @Route("/edit/{id}",name="sec_edit")
     * @ParamConverter("entity", options={"mapping": {"id": "id"}})
     *
     */
    public function editAction(Request $request, Section $entity)
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
            return $this->redirect($this->generateUrl('jview'));

        }
        return $this->render('RpsAdminBundle:Section:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/new", name="sec_new")
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Section();
        $form = $this->createForm(new SectionType(), $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('jview'));
        }

        return $this->render('RpsAdminBundle:Section:new.html.twig', array(
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
    private function createEditForm(Section $entity)
    {
        $form = $this->createForm(new SectionType(), $entity);


        return $form;
    }


    /**
     * @param Request $request
     * @Route("/remove", name="sec_remove")
     * @return Response
     */
    public function RemoveAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $enquiry = $em->getRepository('RpsAdminBundle:Section')->find($request->get('id'));

            $em->remove($enquiry);
            $em->flush();
        }
        return new Response('deleted');
    }


    /**
     * @Route("/selectContent",name="ajaxSelectContent")
     * @param Request $request
     * @return JsonResponse
     */
    public function SelectAjaxContentAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $enquiry = $em->getRepository('RpsAdminBundle:Content')->findBy(array(
                'category' => $request->get('category')
            ));
            $arrayCollection = array();
            foreach ($enquiry as $content) {
                $arrayCollection [] = array(
                    'id' => $content->getId(),
                    'fname' => $content->getFname()
                );
            }


            return new JsonResponse($arrayCollection);

        }

        return false;

    }



    /**
     * @return Response
     * @Route("/jview", name="jview")
     */
    public function jViewAction() {
        return $this->render('RpsAdminBundle:Section:jView.html.twig');

    }

    /**
     * @Route("/tree", name="sec_tree")
     */
    public function ajaxTreeAction() {
        $root = $this->getDoctrine()->getRepository('RpsAdminBundle:Section')->getOrderedByParent(NULL);
        $data['children'] = array();
        $data['state']['opened'] = 'true';
        $data['text'] = 'Корень';
        $data['id'] = 'root';
        foreach ($root as $rootSection) {
            array_push($data['children'],$this->generateTree($rootSection));
        }
        return new JsonResponse($data);
    }


    public function generateTree(Section $section)  {
        $data['id'] = $section->getId();
        $data['children'] = array();
        $data['state']['opened'] = 'true';
        $data['text'] = $section->getFname();
        $data['a_attr']['href']  = $this->generateUrl('sec_edit',array('id' => $section->getId()));
        if( $childrenSections = $section->getChildren() ) {

            foreach ($childrenSections as $child ){
                array_push($data['children'],$this->generateTree($child));
            }
        }return $data;
    }

    /**
     * @Route("/updateParent",name="sec_updateParent")
     * @param Request $request
     * @return Response
     */
    public function ajaxUpdateParentNode(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $sourceNode = $request->get('source');
            $targetNode = $request->get('target');
            $orderedArray = json_decode($request->get('order'));
            $em->getRepository('RpsAdminBundle:Section')->findAndModifyParent($sourceNode,$targetNode);
            foreach ($orderedArray as $order  => $section){
                $em->getRepository('RpsAdminBundle:Section')->findAndModifyOrder($section,$order);

            }
            return new Response('','200');
        }

        return new Response('', '500');
    }


}
