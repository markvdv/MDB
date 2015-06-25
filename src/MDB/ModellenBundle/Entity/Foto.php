<?php

namespace MDB\ModellenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

/**
 * @ORM\Table(name="foto")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Foto{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="naam", type="string",nullable=false)
   * @var type 
   */
  private $naam;

  /**
   * @ORM\Column(name="description", type="text",nullable=true)
   * @var type 
   */
  private $description;

  /**
   *
   * @ORM\Column(type="text", length=255, nullable=false)
   */
  private $path;

  /**
   * Image file
   *
   * @var File
   *
   * @Assert\File(
   *     maxSize = "5M",
   *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
   *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
   *     mimeTypesMessage = "Only the filetypes image are allowed."
   * )
   */
  private $file;

  function getId() {
    return $this->id;
  }

  function getNaam() {
    return $this->naam;
  }

  function getDescription() {
    return $this->description;
  }

  function getPath() {
    return $this->path;
  }

  function getFile() {
    return $this->file;
  }

  function setNaam($naam) {
    $this->naam = $naam;
  }

  function setDescription($description) {
    $this->description = $description;
  }

  function setPath($path) {
    $this->path = $path;
  }

  //function setFile(File $file) {
  function setFile($file) {
    $this->file = $file;
  }

  /**
   * Called before saving the entity
   * 
   * @ORM\PrePersist()
   * @ORM\PreUpdate()
   */
  public function preUpload() {
    if (null !== $this->file) {
      // do whatever you want to generate a unique name
      $filename = sha1(uniqid(mt_rand(), true));
      $this->path = $filename . '.' . $this->file->guessExtension();
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
    $this->file->move(
            $this->getUploadRootDir(), $this->path
    );

    // Set the path property to the filename where you've saved the file
    //$this->path = $this->file->getClientOriginalName();
    // Clean up the file property as you won't need it anymore
    $this->file = null;
  }
/**
 * @ORM\ManyToOne(targetEntity="model",inversedBy="fotos",cascade={"all"})
 * @var type 
 */
  private $model;

  function getModel() {
    return $this->model;
  }

  function setModel($model) {
    $this->model = $model;
    return $this;
  }
 public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
}
