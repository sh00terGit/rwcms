<?php

namespace Nod4\RpsAdminBundle\EventListener;
use Doctrine\ORM\EntityManager;
use Nod4\RpsAdminBundle\Models\UserAgentParser;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class UserAgentListener {


    private $container;
    private $em ;
    private $ua;

    public function __construct($container,EntityManager $em)
    {
        $this->container = $container;
        $this->em = $em;
    }


    public function onKernelRequest(Event $event){
        $session = $this->container->get('session');

        if ($session->get('ua',0) == 0 ) {
            $session->set('ua',1);
            $this->ua = new UserAgentParser();
            $result = $this->ua->parse_user_agent();
            $this->em->getRepository('RpsAdminBundle:History')->saveHistory($result['platform'], $result['browser'], $result['version']);
        }
        return;
    }
}