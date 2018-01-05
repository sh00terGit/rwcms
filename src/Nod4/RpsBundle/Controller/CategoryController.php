<?php

namespace Nod4\RpsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Nod4\RpsBundle\Controller
 * @Route("/category")
 */
class CategoryController extends Controller
{

    /**
     * @var int $currYear текущий год
     */
    public $currYear;
    /**
     * @var int
     */
    public $limitNewsPerPage;

    /**
     * @var int
     */
    public $limitYears;




    public function __construct() {

        $this->currYear = date("Y");
        $this->limitNewsPerPage = 3;
        $this->limitYears = 3;
    }



    /**
     * @Route("/{id}/{year}/{page}", name="category_view",
     *     requirements={"year" = "\d+" , "page" = "\d+" ,"id" = "\d+" },
     *     defaults={"year" = 2017, "page" = 1})
     * @param int $year
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryAction($id,$year ,$page) {

        $years = $this->genYears($this->currYear,$this->limitYears);

        return $this->render('RpsBundle:Category:CategoryView.html.twig', array(
            'page' => $page,
            'year' => $year,
            'arrYears' => $years,
            'category' => $id
        ));
    }

    /**
     * @Route("/select", name="category_year_change")
     * @param  $request Request
     * @return Response json
     */
    public function ajaxSelectAction(Request $request) {
        $year = $request->get('year');
        $page =  $request->get('page');
        $category =  $request->get('category');
        $em = $this->getDoctrine()->getManager();
        $contents = $em->getRepository('RpsAdminBundle:Content')
            ->findCategoryPageByYear($category,$year, $page, $this->limitNewsPerPage);
        $countPages = $this->countPagesByYear($category,$year);

        $years = $this->genYears($year,$this->limitYears);

        return new Response($this->renderView('RpsBundle:Category:CategoryTemplate.html.twig', array(
            'category' => $category,
            'contents' => $contents,
            'countPages' => $countPages,
            'page' => $page,
            'year' => $year,
            'arrYears' => $years
        )));

    }

    /**
     * @param $year
     * @param $category
     * @return int
     */
    private function countPagesByYear($category,$year)
    {
        $em = $this->getDoctrine()->getManager();
        $countRows = $em->getRepository('RpsAdminBundle:Content')->count($category,$year);
        $countPages = floor(($countRows - 1) / 3) + 1;
        return $countPages;
    }





    /**
     * @param $startYear
     * @param $limitYears
     * @return array
     */
    private function genYears($startYear, $limitYears)
    {
        $years = array();
        for ($i = $startYear - $limitYears; $i <= $startYear; $i++) {
            $years[] = $i;
        }
        return $years;
    }

}
