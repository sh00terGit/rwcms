<?php

namespace Nod4\RpsAdminBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\EntityManager;

/**
 * SectionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SectionRepository extends EntityRepository
{

    public function findAndModifyParent($source , $target) {


        $qb = $this->createQueryBuilder('sec')
                ->update()
                 ->set('sec.parent', $target)
                 ->where('sec.id = :source')
                 ->setParameter('source',$source);

        return $qb->getQuery()->execute();
    }


    public function getOrderedByParent($parent) {

        $qb = $this->findBy(
            array('parent' => $parent),
            array('depth' => 'ASC'));
        return $qb;
    }


    public function findAndModifyOrder($source , $order) {
        $qb = $this->createQueryBuilder('sec')
            ->update()
            ->set('sec.depth', $order)
            ->where('sec.id = :source')
            ->setParameter('source',$source);

        return $qb->getQuery()->execute();
    }

}