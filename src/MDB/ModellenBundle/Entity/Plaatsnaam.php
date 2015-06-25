<?php

namespace MDB\ModellenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postcode
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MDB\ModellenBundle\Repository\PlaatsnaamRepository")
 */
class Plaatsnaam {

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
   * @ORM\Column(name="plaatsnaam", type="string", length=255,nullable=true)
   */
  private $plaatsnaam;


  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set plaatsnaam
   *
   * @param string $plaatsnaam
   * @return Plaatsnaam
   */
  public function setPlaatsnaam($plaatsnaam) {
    $this->plaatsnaam = $plaatsnaam;

    return $this;
  }

  /**
   * Get plaatsnaam
   *
   * @return string 
   */
  public function getPlaatsnaam() {
    return $this->plaatsnaam;
  }


  /**
   * @ORM\OneToMany(targetEntity="Adres",mappedBy="plaatsnaam")
   * @var type 
   */
  private $adres = null;

  function getAdres() {
    return $this->adres;
  }

  function setAdres(Adres $adres) {
    $this->adres = $adres;
  }

/**
 *@ORM\ManyToOne(targetEntity="Postcode",inversedBy="plaatsnaam",cascade="persist")
 * @return type  
 */
private $postcode=null;
  function getPostcode() {
    return $this->postcode;
  }

  function setPostcode($postcode) {
    $this->postcode = $postcode;
  }

}
