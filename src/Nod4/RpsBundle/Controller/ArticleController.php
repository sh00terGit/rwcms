<?php

namespace Nod4\RpsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ArticleController
 * @Route("/article")
 * @package Nod4\RpsBundle\Controller
 */
class ArticleController extends Controller
{

    /** Становление
     * @Route("/stanovlenie", name="stanovlenie")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stanovlenieAction()
    {
        return $this->render('RpsBundle:Default/article:stanovlenie.html.twig', array('title' => 'Становление'));
    }


    /**
     * @Route("/structura", name="structura")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function structuraAction()
    {
        return $this->render('RpsBundle:Default/article:structura.html.twig', array('title' => 'Структура Райпрофсожа'));
    }


    /**
     * @Route("/contact", name="contact")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction()
    {
        return $this->render('RpsBundle:Default/article:contact.html.twig', array('title' => 'Контакты'));
    }


    /**
     * @Route("/napravlenie", name="napravlenie")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function napravlenieAction()
    {
        return $this->render('RpsBundle:Default/article:napravlenie.html.twig', array('title' => 'Направление деятельности'));
    }


    /**
     * @Route("/tasks", name="tasks")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tasksAction()
    {
        return $this->render('RpsBundle:Default/article:tasks.html.twig', array('title' => 'Основные задачи'));
    }


    /**
     * @Route("/ozdorovlenie", name="ozdorovlenie")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function ozdorovlenieAction()
    {
        return $this->render('RpsBundle:Default/article:ozdorovlenie.html.twig', array('title' => 'Оздоровление'));
    }


    /**
     * @Route("/infoday", name="infoday")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function infodayAction()
    {
        return $this->render('RpsBundle:Default/article:infoday.html.twig', array('title' => 'Проведение информационного дня Дорпрофсожа 17.09.2015 на Гомельском узле'));
    }

    /**
     * @Route("/sport", name="sport")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sportAction()
    {
        return $this->render('RpsBundle:Default/article:sport.html.twig', array('title' => 'Спортакиады'));
    }

}
