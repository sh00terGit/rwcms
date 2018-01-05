<?php

namespace Nod4\RpsAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MpContent
 *
 * @ORM\Table(name="mp_content", indexes={@ORM\Index(name="content_id", columns={"content_id"}), @ORM\Index(name="category_id", columns={"category_id"}), @ORM\Index(name="part_id", columns={"part_id"})})
 * @ORM\Entity(repositoryClass="Nod4\RpsAdminBundle\Entity\Repository\MpContentRepository")
 */
class MpContent
{
    /**
     * @var \Nod4\RpsAdminBundle\Entity\Content
     *
     * @ORM\ManyToOne(targetEntity="Nod4\RpsAdminBundle\Entity\Content")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     * })
     */
    private $contentId;

    /**
     * @var \Nod4\RpsAdminBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Nod4\RpsAdminBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $categoryId;



    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Nod4\RpsAdminBundle\Entity\MpPart
     *
     * @ORM\ManyToOne(targetEntity="Nod4\RpsAdminBundle\Entity\MpPart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="part_id", referencedColumnName="id")
     * })
     */
    private $part;



    /**
     * Set contentId
     *
     * @param integer $contentId
     * @return MpContent
     */
    public function setContentId($contentId)
    {
        $this->contentId = $contentId;
    
        return $this;
    }

    /**
     * Get contentId
     *
     * @return integer 
     */
    public function getContentId()
    {
        return $this->contentId;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     * @return MpContent
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    
        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer 
     */
    public function getCategoryId()
    {
        return $this->categoryId;
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
     * Set part
     *
     * @param \Nod4\RpsAdminBundle\Entity\MpPart $part
     * @return MpContent
     */
    public function setPart(\Nod4\RpsAdminBundle\Entity\MpPart $part = null)
    {
        $this->part = $part;
    
        return $this;
    }

    /**
     * Get part
     *
     * @return \Nod4\RpsAdminBundle\Entity\MpPart 
     */
    public function getPart()
    {
        return $this->part;
    }
}
