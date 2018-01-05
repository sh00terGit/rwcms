<?php

namespace Nod4\RpsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Nod4\RpsAdminBundle\Entity\News;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller 
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

    /**
     * DefaultController constructor.
     */
    public function __construct() {
       
        $this->currYear = date("Y");
        $this->limitNewsPerPage = 3;
        $this->limitYears = 3;
    }

    /**
     * @Route("/", name="home_page")
     * 
     */

    public function indexAction(){
        $mp= $this->container->get('cms.main_page');
        return $this->render('RpsBundle:MainPage:MainPage.html.twig',array('mp' => $mp));
    }

/*  старая автогенерация главной
      public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('RpsAdminBundle:Content')
            ->findCategoryPageByYear(null,$this->currYear,1,$this->limitNewsPerPage);
        return $this->render('RpsBundle:Default:index.html.twig', array(
                    'newsArray' => $news
        ));
    }*/

    /**
     * @Route("/news/{year}/{page}", name="home_news",
     *     requirements={"year" = "\d+" , "page" = "\d+"},
     *     defaults={"year" = 2017, "page" = 1})
     * @param int $year
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newsAction($year ,$page) {

        $years = $this->genYears($this->currYear,$this->limitYears);

           return $this->render('RpsBundle:Default:news.html.twig', array(
            'page' => $page,
            'year' => $year,
            'arrYears' => $years,
        ));
    }


    /**
     * @Route("/news/view/{id}", name="home_news_view")
     * @param $news News
     * @return Response
     */
    public function viewNewsAction(News $news){
        return $this->render('RpsBundle:Default:viewNews.html.twig', array(
                    'news' => $news,
        ));
    }


    /**
     * @Route("/news/select", name="home_news_year_change")
     * @param  $request Request
     * @return Response json
     */
    public function ajaxSelectAction(Request $request) {
            $year = $request->get('year');
            $page =  $request->get('page');
            $em = $this->getDoctrine()->getManager();
            $news = $em->getRepository('RpsAdminBundle:News')->findPageByYear($year, $page, $this->limitNewsPerPage);
            $countPages = $this->countPagesByYear($year);


            return new Response($this->renderView('RpsBundle:Default:newsTemplate.html.twig', array(
                'newsArray' => $news,
                'countPages' => $countPages,
                'page' => $page,
                'year' => $year
            )));

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

    /**
     * @param $year
     * @return int
     */
    private function countPagesByYear($year)
    {
        $em = $this->getDoctrine()->getManager();
        $countRows = $em->getRepository('RpsAdminBundle:News')->count($year);
        $countPages = floor(($countRows - 1) / 3) + 1;
        return $countPages;
    }




}
