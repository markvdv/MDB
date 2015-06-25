<?php

namespace MDB\RedacteurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MDB\RedacteurBundle\Repository\RatingRepository")
 */
class Rating {

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var integer
   *
   * @ORM\Column(name="waarde", type="decimal",precision=2, scale=1)
   */
  private $waarde;

  /**
   * @ORM\ManyToOne(targetEntity="MDB\RedacteurBundle\Entity\Redacteur",inversedBy="ratings",cascade={"all"})
   * @var type 
   */
  private $redacteur;

  /**
   * @ORM\ManyToOne(targetEntity="MDB\ModellenBundle\Entity\Model",inversedBy="ratings",cascade={"all"})
   * @var type 
   */
  private $model;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set waarde
   *
   * @param integer $waarde
   * @return Rating
   */
  public function setWaarde($waarde) {
    $this->waarde = $waarde;

    return $this;
  }

  /**
   * Get waarde
   *
   * @return integer 
   */
  public function getWaarde() {
    return $this->waarde;
  }

  /**
   * Set userid
   *
   * @param integer $userid
   * @return Rating
   */
  public function setRedacteur($redacteur) {
    $this->redacteur = $redacteur;

    return $this;
  }

  /**
   * Get userid
   *
   * @return integer 
   */
  public function getRedacteur() {
    return $this->redacteur;
  }

  /**
   * Set model
   *
   * @param integer $model
   * @return Rating
   */
  public function setModel($model) {
    $this->model = $model;

    return $this;
  }

  /**
   * Get model
   *
   * @return integer 
   */
  public function getModel() {
    return $this->model;
  }

}
