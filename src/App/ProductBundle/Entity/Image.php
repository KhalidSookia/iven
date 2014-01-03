<?php

namespace App\ProductBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="App\ProductBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    private $url;



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
     * Set url
     *
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    private $file;
    private $tempFilename;

    public function setFile(UploadedFile $file){
        $this->file = $file;

        if(null !== $this->url){
            $this->tempFilename = $this->url;
            $img_name = \uniqid();        
            $this->url = null;
        }
    }
    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload(){
        if(null === $this->file){
            return;
        }
        $img_name = \uniqid();        

        $this->url = $img_name.'.'.$this->file->guessExtension();
    }

    public function upload(){
        if(null === $this->file){
            return;
        }
        if(null !== $this->tempFilename){
            $oldFile = $this->getUploadRootDir().'/'.$img_name.'.'.$this->tempFilename;
            if(file_exists($oldFile)){
                unlink($oldFile);
            }
        }
        $this->file->move(
            $this->getUploadRootDir(),
            $this->url);
    }

    /**
    * @ORM\PreRemove()
    */
    public function preRemoveUpload(){
        $this->tempFilename = $this->getUploadRootDir().'/'.$img_name.'.'.$this->url;
    }
    /**
    * @ORM\PostRemove()
    */
    public function removeUpload(){
        if(file_exists($this->tempFilename)){
            unlink($this->tempFilename);
        }
    }

    public function getUploadDir(){
        return 'uploads/img';
    }
    protected function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath(){
        return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }
}