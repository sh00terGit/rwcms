<?php

namespace Nod4\RpsAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Nod4\RpsAdminBundle\Models\ImageResize;

/**
 * NewsImg
 *
 * @ORM\Table(name="news_img")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class NewsImg {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

    /**
     * @var integer
     * 
     * @ORM\ManyToOne(targetEntity="Nod4\RpsAdminBundle\Entity\News", inversedBy="images" )
     * 
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     */
    private $news;

    /**
     *
     * @Assert\NotBlank()
     */
    public $file;

    /**
     * Called before saving the entity
     * 
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        if (null !== $this->file) {


            // do whatever you want to generate a unique name
//           $filename = "img_".$this->getNews()->getId()."_". rand() .$this->file->guessExtension();
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->file->guessExtension();
        }
    }

    /**
     * Called before entity removal
     *
     * @ORM\PreRemove()
     */
    public function removeUpload() {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }

    /**
     * Called after entity persistence
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
        // The file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        // Use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the
        // target filename to move to
//        $this->file->move(
//                $this->getUploadRootDir(), $this->path
//        );
        try {
            $imageResizer = new ImageResize();
            $uploadPath = $this->getUploadRootDir() .'/'. $this->path;
            $size = $this->file->getClientSize();
            if($size >300000) {   // 300kb
                $imageResizer->smart_resize_image(null, file_get_contents($this->file), 1024, 0, true, $uploadPath, false, false, 100);
            } else {
                $this->file->move($this->getUploadRootDir(),$this->path);
            }
            } catch (Exception $exc) {
            exit('upload error');
        }


//         $this->file->move(
//                $this->getUploadRootDir(), $this->path
//        );
      
        $this->file = null;
    }

    public function getAbsolutePath() {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath() {
        return null === $this->path ? null : '/web'. $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir() {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__ . '/../../../../web' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '/uploads/news/images';
    }

    public function getFile() {
        return $this->file;
    }

    public function setFile(UploadedFile $file) {
        $this->file = $file;
//        $this->path = $file->getClientOriginalName();
        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return NewsImg
     */
    public function setPath($path) {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
    }

    /**
     * Set news
     *
     * @param \Nod4\RpsAdminBundle\Entity\News $news
     * @return NewsImg
     */
    public function setNews(\Nod4\RpsAdminBundle\Entity\News $news = null) {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \Nod4\RpsAdminBundle\Entity\News 
     */
    public function getNews() {
        return $this->news;
    }

//    public function getWebPath() {
//        $webPath = 'web/uploads/news/images/tupl.jpg';
//
//        return $webPath;
//    }
}
