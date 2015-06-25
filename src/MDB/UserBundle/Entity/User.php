<?php

namespace MDB\UserBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *@ORM\Entity
 * @ORM\Table()
 */
class User extends BaseUser{
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

}
