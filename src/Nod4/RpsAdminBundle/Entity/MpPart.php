<?php

namespace Nod4\RpsAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MpPart
 *
 * @ORM\Table(name="mp_part")
 * @ORM\Entity
 */
class MpPart
{
    /**
     * @var string
     *
     * @ORM\Column(name="partName", type="string", length=50, nullable=false)
     */
    private $partName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", nullable=false)
     */
    private $status;



    /**
     * @var boolean
     *
     * @ORM\Column(name="auto", type="boolean", nullable=false)
     */
    private $auto;

    /**
     * @var boolean
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $priority;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @ORM\OneToMany(targetEntity="Nod4\RpsAdminBundle\Entity\MpContent" ,mappedBy="part" ,cascade={"all"},orphanRemoval=true, fetch="LAZY" )
     */
    private $partContents;





    /**
     * @return bool
     */
    public function isAuto()
    {
        return $this->auto;
    }

    /**
     * @param bool $auto
     * @return MpPart
     */
    public function setAuto($auto)
    {
        $this->auto = $auto;
        return $this;
    }


    /**
     * Set partName
     *
     * @param string $partName
     * @return MpPart
     */
    public function setPartName($partName)
    {
        $this->partName = $partName;
    
        return $this;
    }

    /**
     * Get partName
     *
     * @return string 
     */
    public function getPartName()
    {
        return $this->partName;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return MpPart
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set priority
     *
     * @param boolean $priority
     * @return MpPart
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    
        return $this;
    }

    /**
     * Get priority
     *
     * @return boolean 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partContents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add partContents
     *
     * @param \Nod4\RpsAdminBundle\Entity\MpContent $partContents
     * @return MpPart
     */
    public function addPartContent(\Nod4\RpsAdminBundle\Entity\MpContent $partContents)
    {
        $partContents->setPart($this);
        $this->partContents[] = $partContents;
    
        return $this;
    }

    /**
     * Remove partContents
     *
     * @param \Nod4\RpsAdminBundle\Entity\MpContent $partContents
     */
    public function removePartContent(\Nod4\RpsAdminBundle\Entity\MpContent $partContents)
    {
        $this->partContents->removeElement($partContents);
    }

    /**
     * Get partContents
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPartContents()
    {
        return $this->partContents;
    }
}
