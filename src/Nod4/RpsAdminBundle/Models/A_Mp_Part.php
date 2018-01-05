<?php

namespace Nod4\RpsAdminBundle\Models;

use Nod4\RpsAdminBundle\Entity\MpPart;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class A_Mp_Part
{
    public $status;                 //вкл-выкл
    public $priority;               //каким выводить
    public $template;               //шаблон
    public $defaultTemplate;        //дефолтный шаблон
    public $content = array();      //содержимое
    public $em;                     // EntityManager
    public $partName;               //название плагина
    public $partModel;              //модель бд плагина
    public $currYear;               // текущий год
    public $container;

    public $auto;                   // режим вывода  (назначенные или авто)

    public function __construct(ContainerInterface $containerAware)
    {
        $this->currYear = date("Y");
        $this->container = $containerAware;
        $this->em =  $this->container->get('doctrine.orm.default_entity_manager');
        $this->setPartName();
        $this->partModel =  $this->em->getRepository('RpsAdminBundle:MpPart')->findOneBy(array('partName' =>$this->partName));
        $this->setDefaultTemplate();
        $this->setStatus();
        $this->setPriority();
        $this->isAuto() ? $this->setAutoContent() :$this->setContent();
    }

    /**
     * В контент последние 3 контента
     */
    public function setAutoContent() {
        $this->content = $this->em->getRepository('RpsAdminBundle:Content')->findBy(array(),array(
            'dateCreate' => 'DESC'
        ),3);
    }


    // наименование плагина в бд  (храниться в каждом наследуемом классе)
    abstract public function setPartName();

    // данные для хранения
    abstract public function setContent();

    // дефолтный шаблон
    abstract public function setDefaultTemplate();


    public function getContent() {
        return $this->content;
    }

    public function getStatus()
    {
        return $this->status;
    }


    /**
     * @return bool
     */
    public function isAuto()
    {
        if($this->partModel instanceof MpPart) {
            $this->auto = $this->partModel->isAuto();
        }
        return $this->auto;
    }

    public function setStatus()
    {
        if($this->partModel instanceof MpPart) {

            $this->status = $this->partModel->getStatus();
       } else {
            $this->status = 0;
        }
        return $this;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority()
    {
        if($this->partModel instanceof MpPart) {
            $this->priority = $this->partModel->getPriority();
        } else {
            throw new Exception('Ошибка плагина');
        }
        return $this;
    }

    public function setTemplate($templatePath)
    {
        $this->template = $templatePath;
        if(!$templatePath)
            $this->template = $this->defaultTemplate;
        return $this;

    }

    public function getTemplate()
    {
        if(!$this->template) {
            $this->template = $this->defaultTemplate;
        }
        return $this->template;
    }

}