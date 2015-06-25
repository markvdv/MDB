<?php

namespace MDB\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MDB\AdminBundle\Repository\AdminRepository;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Admin
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AdminRepository")
 */
class Admin extends BaseUser {
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
