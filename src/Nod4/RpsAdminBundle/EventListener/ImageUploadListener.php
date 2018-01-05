<?php

namespace Nod4\RpsAdminBundle\EventListener;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Nod4\RpsAdminBundle\Entity\NewsImg;
use Nod4\RpsAdminBundle\FileUploader;

class ImageUploadListener {

    private $uploader;
    private $fileName;

    public function __construct(FileUploader $uploader) {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        
        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $entity = $args->getEntity();        
        $this->uploadFile($entity);
    }

    private function uploadFile($entity) {
        // upload only works for Product entities

        if (!$entity instanceof NewsImg) {
            return;
        }       
            $file = $entity->getFile();
            // only upload new files
            if ($file instanceof UploadedFile) {                
                $fileName = $this->uploader->upload($file);      
            }
//            $entity->getImages()->get($key)->setPath($fileName);
//            $key++;
        
    }


}
