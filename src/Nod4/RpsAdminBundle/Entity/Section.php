<?php

namespace Nod4\RpsAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table(name="section", indexes={@ORM\Index(name="cat_id", columns={"cat_id"}), @ORM\Index(name="content_id", columns={"content_id"})})
 * @ORM\Entity(repositoryClass="Nod4\RpsAdminBundle\Entity\Repository\SectionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Section
{


    public function __toString()
    {
       return (string)$this->getId();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=100, nullable=false)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="sname", type="string", length=50, nullable=false)
     */
    private $sname;

    /**
     * @var string
     *
     * @ORM\Column(name="type_output", type="string", nullable=false)
     */
    private $typeOutput;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Nod4\RpsAdminBundle\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="Nod4\RpsAdminBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cat_id", referencedColumnName="id")
     * })
     */
    private $category;



    /**
     * @var integer
     *
     * @ORM\Column(name="depth", type="integer", nullable=true)
     */
    private $depth;




    /**
     * @var \Nod4\RpsAdminBundle\Entity\Content
     *
     * @ORM\ManyToOne(targetEntity="Nod4\RpsAdminBundle\Entity\Content")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="content_id", referencedColumnName="id")
     * })
     */
    private $content;



    /**
     * @ORM\ManyToOne(targetEntity="Nod4\RpsAdminBundle\Entity\Section", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE" , nullable=true)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Nod4\RpsAdminBundle\Entity\Section", mappedBy="parent")
     */
    private $children;







    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param int $depth
     * @return Section
     */
    public function setDepth($depth)
    {
        /*if($this->getParent() != null) {
            $countChilds = count( $this->getParent()->getChildren());
            $this->order = $countChilds++;
        }*/
        $this->depth = $depth;
        return $this;
    }


    /**
     * Set fname
     *
     * @param string $fname
     * @return Section
     */
    public function setFname($fname)
    {
        $this->fname = $fname;
    
        return $this;
    }

    /**
     * Get fname
     *
     * @return string 
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set sname
     *
     * @param string $sname
     * @return Section
     */
    public function setSname($sname)
    {
        $this->sname = $sname;
    
        return $this;
    }

    /**
     * Get sname
     *
     * @return string 
     */
    public function getSname()
    {
        return $this->sname;
    }


    /**
     * Пустое короткое имя заполняется  полным
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */

    public function setEmptyNames()
    {
        if($this->getSname() == null ) {
            $this->setSname($this->getFname());
        }
    }





    /**
     * Set typeOutput
     *
     * @param string $typeOutput
     * @return Section
     */
    public function setTypeOutput($typeOutput)
    {
        $this->typeOutput = $typeOutput;
    
        return $this;
    }

    /**
     * Get typeOutput
     *
     * @return string 
     */
    public function getTypeOutput()
    {
        return $this->typeOutput;
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
     * Set category
     *
     * @param \Nod4\RpsAdminBundle\Entity\Category $category
     * @return Section
     */
    public function setCategory(\Nod4\RpsAdminBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Nod4\RpsAdminBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set content
     *
     * @param \Nod4\RpsAdminBundle\Entity\Content $content
     * @return Section
     */
    public function setContent(\Nod4\RpsAdminBundle\Entity\Content $content = null)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return \Nod4\RpsAdminBundle\Entity\Content 
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set parent
     *
     * @param \Nod4\RpsAdminBundle\Entity\Section $parent
     * @return Section
     */
    public function setParent(\Nod4\RpsAdminBundle\Entity\Section $parent = null)
    {
        $this->parent = $parent;
    
        return $this;
    }

    /**
     * Get parent
     *
     * @return \Nod4\RpsAdminBundle\Entity\Section 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \Nod4\RpsAdminBundle\Entity\Section $children
     * @return Section
     */
    public function addChild(\Nod4\RpsAdminBundle\Entity\Section $children)
    {
        $this->children[] = $children;
    
        return $this;
    }

    /**
     * Remove children
     *
     * @param \Nod4\RpsAdminBundle\Entity\Section $children
     */
    public function removeChild(\Nod4\RpsAdminBundle\Entity\Section $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }
}
