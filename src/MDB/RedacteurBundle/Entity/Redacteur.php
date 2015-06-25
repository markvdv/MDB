<?php

namespace MDB\RedacteurBundle\Entity;

use MDB\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Redacteur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MDB\RedacteurBundle\Repository\RedacteurRepository")
 */
class Redacteur extends BaseUser {

  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  
  
  protected $email;

  /**
   * @ORM\OneToMany(targetEntity="Rating",mappedBy="redacteur",cascade={"all"})
   */
  private $ratings;

  function getRatings() {
    return $this->ratings;
  }

  function setRatings($ratings) {
    $this->ratings = $ratings;
    return $this;
  }

  public function addRating($rating) {
    $this->ratings[] = $rating;
  }

  public function removeRating($rating) {
    foreach ($this->ratings as $key => $value) {
      if ($value == $rating) {
        unset($this->ratings[$key]);
      }
    }
  }

  public function getId() {
    return $this->id;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
    return $this;
  }

}
