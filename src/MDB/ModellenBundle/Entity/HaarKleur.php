<?php
namespace MDB\ModellenBundle\Entity;

use MDB\ModellenBundle\Entity\Kleur;
use Doctrine\ORM\Mapping as ORM;
/**
 * HaarKleur
 *
 * @ORM\Table("haarkleur")
 * @ORM\Entity(repositoryClass="MDB\ModellenBundle\Repository\HaarKleurRepository")
 */
class HaarKleur extends Kleur{
    /**
   * @ORM\OneToMany(targetEntity="model",mappedBy="haarKleur")
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


}
