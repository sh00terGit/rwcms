<?php

namespace Nod4\RpsAdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\EntityManager;

/**
 * Class NewsRepository
 * @package Nod4\RpsAdminBundle\Entity\Repository
 */
class NewsRepository extends EntityRepository {

    /**
     * NewsRepository constructor.
     * @param EntityManager $em
     * @param Mapping\ClassMetadata $class
     */
    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'Nod4\RpsAdminBundle\DQL\DqlYear');
       }


    /**
     * Рендерит  новости на страницу для пагинации
     * @param $year год
     * @param $page страница
     * @param $limitPerPage кол-во на странице
     * @return array
     */
    public function findPageByYear($year, $page, $limitPerPage) {


        $page = $this->isPage($page);
        $limit=$limitPerPage;
        $offset=$limitPerPage*($page-1);
        $qb = $this->createQueryBuilder('news')
                ->where('YEAR(news.date) = :year')
                ->setParameter('year',$year)
                ->orderBy('news.date', 'DESC')      
                ->setFirstResult($offset)    
               ->setMaxResults($limit);

        return $qb->getQuery()
                        ->getResult();
    }

    /**
     * Количество новостей за указанный год
     * @param $year год
     * @return mixed|null
     */
    public function count($year) {

        $qb = $this->createQueryBuilder('news')
            ->select('COUNT(news.id)')
            ->where('YEAR(news.date) = :year')
            ->setParameter('year',$year);
        try {
            $count = $qb->getQuery()->getSingleScalarResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            /* Your stuffs.. */
        }
        return $count!=NULL ? $count : NULL;
    }


    /**
     * @param $page
     * @return int
     */
    private function isPage($page) {
        return $page !=NULL ? $page : 1 ;
    }

}
