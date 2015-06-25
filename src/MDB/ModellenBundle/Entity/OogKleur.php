<?php
namespace MDB\ModellenBundle\Entity;

use MDB\ModellenBundle\Entity\Kleur;
use Doctrine\ORM\Mapping as ORM;
/**
 * OogKleur
 *
 * @ORM\Table("oogkleur")
 * @ORM\Entity(repositoryClass="MDB\ModellenBundle\Repository\OogKleurRepository")
 */
class OogKleur extends Kleur{
  /**
   * @ORM\OneToMany(targetEntity="model",mappedBy="oogKleur")
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
