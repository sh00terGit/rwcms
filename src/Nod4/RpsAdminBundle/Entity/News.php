<?php

namespace Nod4\RpsAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="Nod4\RpsAdminBundle\Entity\Repository\NewsRepository")
 */
class News {

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", length=65535, nullable=true)
     */
    private $text;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

     /**
     * @ORM\OneToMany(targetEntity="Nod4\RpsAdminBundle\Entity\NewsImg", mappedBy="news" ,cascade={"all"},orphanRemoval=true, fetch="LAZY")
     */
     private $images;
    
    
    private $shortText;





    /**
     * Set title
     *
     * @param string $title
     * @return News
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return News
     */
    public function setText($text) {
        $this->text = $text;
        $this->setShortText($text);
        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText() {
        return $this->text;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return News
     */
    public function setDate($date) {
        $this->date = $date;       
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate() {
        return $this->date;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    public function getImages() {
        return $this->images;
    }

    public function setImages($images) {
        $this->images = $images;
        return $this;
    }


  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add images
     *
     * @param \Nod4\RpsAdminBundle\Entity\NewsImg $images
     * @return News
     */
    public function addImage(\Nod4\RpsAdminBundle\Entity\NewsImg $images)
    {
        if($images->getFile()!= null) {
            $images->setNews($this);
            $this->images[] = $images;
        }
        return $this;

    }
    
   

    /**
     * Remove images
     *
     * @param \Nod4\RpsAdminBundle\Entity\NewsImg $images
     */
    public function removeImage(\Nod4\RpsAdminBundle\Entity\NewsImg $images)
    {
       if($images->getFile() == null) {        
        $this->images->removeElement($images);
       
       
       }
    }
    
    function getFirstImage() { 
        if( $this->getImages()->count() !== 0) {
//        $imgCount= $this->getImages()->count();
//        $random = rand(1, $imgCount);
//        
        return $this->getImages()->first()->getWebPath();
        }
        else {
           return "/web/images/none.jpg"; 
        }
        
//        return  $images!=null ? $images[array_rand($images, 1)] : null;
//   return  $images!=null ? $images->toArray() : null;
        }
    
    
    
    
     public function setShortText($text) {
        $text = strip_tags($text);
        $this->shortText = $this->mySubstr($text);
        return $this;
    }

    public function getShortText() {
        $this->setShortText($this->text);
        return $this->shortText;
    }
    
     public function mySubstr($text, $symbols = 200) {
        $symbols = (int) $symbols;

        if (strlen($text) <= $symbols)
            return $text;

        $pos = mb_strpos($text,' ', 200,'UTF-8');
        return mb_substr($text, 0, (int) $pos, 'UTF-8')."....";
    }
    
}
