<?php

namespace Nod4\RpsAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="content", indexes={@ORM\Index(name="cat_id", columns={"cat_id"})})
 * @ORM\Entity(repositoryClass="Nod4\RpsAdminBundle\Entity\Repository\ContentRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Content
{
    /**
     * @var string
     *
     * @ORM\Column(name="fname", type="string", length=100, nullable=false)
     */
    private $fname;

    /**
     * @var string
     *
     * @ORM\Column(name="sname", type="string", length=50, nullable=true)
     */
    private $sname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_create", type="date", nullable=false)
     */
    private $dateCreate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_update", type="date", nullable=false)
     */
    private $dateUpdate;

    /**
     * @var string
     *
     * @ORM\Column(name="ftext", type="text", length=65535, nullable=false)
     */
    private $ftext;

    /**
     * @var string
     *
     * @ORM\Column(name="stext", type="string", length=255, nullable=true)
     */
    private $stext;

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
     * @ORM\OneToMany(targetEntity="Nod4\RpsAdminBundle\Entity\ContentImage" ,mappedBy="content" ,cascade={"all"},orphanRemoval=true, fetch="LAZY")
     */
    private $images;




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function setShortText($text) {
        $text = strip_tags($text);
        $this->stext = $this->mySubstr($text);
        return $this;
    }

    public function getShortText() {
        $this->setShortText($this->ftext);
        return $this->stext;
    }




    /**
     * Обновляем дату содания , обновления
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        $this->setUpdatedDate();

        if ($this->getDateCreate() == null) {
            $this->setDateCreate(new \DateTime('now'));
        }
    }


    public function setUpdatedDate()
    {
        $this->dateUpdate =  new \DateTime("now");
        return $this;
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
     * Set fname
     *
     * @param string $fname
     * @return Content
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
     * @return Content
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
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Content
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;
    
        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return Content
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;
    
        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set ftext
     *
     * @param string $ftext
     * @return Content
     */
    public function setFtext($ftext)
    {
        $this->ftext = $ftext;
    
        return $this;
    }

    /**
     * Get ftext
     *
     * @return string 
     */
    public function getFtext()
    {
        return $this->ftext;
    }

    /**
     * Set stext
     *
     * @param string $stext
     * @return Content
     */
    public function setStext($stext)
    {
        $this->stext = $stext;
    
        return $this;
    }

    /**
     * Get stext
     *
     * @return string 
     */
    public function getStext()
    {
        return $this->stext;
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
     * @return Content
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
     * Add images
     *
     * @param \Nod4\RpsAdminBundle\Entity\ContentImage $images
     * @return Content
     */
    public function addImage(\Nod4\RpsAdminBundle\Entity\ContentImage $images)
    {
        if($images->getFile()!= null) {
            $images->setContent($this);
            $this->images[] = $images;
        }
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Nod4\RpsAdminBundle\Entity\ContentImage $images
     */
    public function removeImage(\Nod4\RpsAdminBundle\Entity\ContentImage $images)
    {
        if($images->getFile() == null) {
            $this->images->removeElement($images);


        }
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    public function mySubstr($text, $symbols = 250) {
        $symbols = (int) $symbols;

        if (strlen($text) <= $symbols)
            return $text;

        $pos = mb_strpos($text,' ', $symbols,'UTF-8');
        return mb_substr($text, 0, (int) $pos, 'UTF-8')."....";
    }



    function getFirstImage() {
        if( $this->getImages()->count() !== 0) {

            return $this->getImages()->first()->getWebPath();
        }
        else {
            return "/web/images/none.jpg";
        }

    }




}
