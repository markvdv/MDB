<?php

namespace MDB\UserBundle\Service;

use Exception;
use MDB\UserBundle\Entity\User;

class UserService extends Service {

  public function __construct($em) {
    parent::__construct($em);
  }
  /**
   * 
   */
  public function listUsers() {
    $users=parent::$em->getRepository('MDBUserBundle:User')->getAll();
    return $users;
  }
  /**
   * logt de user in 
   * @param string $nicknaam: nicknaam van de user
   * @param string $paswoord:paswoord van de user
   */
  public function login($nicknaam = null, $paswoord = null) {
   
    if ($nicknaam === null) {
      parent::$errors[] = new Exception('geen nicknaam ingevuld',2);
    }
    if ($paswoord === null) {
      parent::$errors[] = new Exception('geen paswoord ingevuld',3);
    }
    if (count(parent::$errors) > 0) {
      return parent::$errors;
    }
    $user = parent::$em->getRepository('MDBUserBundle:User')->findBy(array('nickNaam'=>$nicknaam));
    if ($user) {
      if ($user->getPaswoord() == hash('sha256',$paswoord.$user->getSalt())) {
        return $user;
      } else {
        parent::$errors[] = new Exception('paswoord incorrect',1);
      }
    } else {
      parent::$errors[] = new Exception('nicknaam niet geregistreerd',0);
    }
    return parent::$errors;
  }
/**
 * @param string $nicknaam
 * @param string $paswoord
 * @param string $naam
 * @param string $voornaam
 * @return array $errors: fouten array
 */
  public function createUser($voornaam, $naam, $nicknaam, $paswoord, $email,$accesslevel) {
    $user = parent::$em->getRepository('MDBUserBundle:User')->findByNicknaam($nicknaam);
    if ($user) {
      parent::$errors[] = new Exception("nicknaam al geregistreerd");
    } else {
      $user = new User();
      $salt = bin2hex(openssl_random_pseudo_bytes(mt_rand(40, 50))); //random salt
      $paswoord=hash('sha256',$paswoord.$salt);
      $user->setNicknaam($nicknaam)->setNaam($naam)->setVoornaam($voornaam)->setPaswoord($paswoord)->setSalt($salt)->setEmail($email)->setAccesslvl($accesslevel);
      parent::$em->getRepository('MDBUserBundle:User')->createUser($user);
      return $user;
    }
    return parent::$errors;
  }
  
  public function deleteUser($user) {
    parent:$em->getRepository('MDBUserBundle:User')->deleteUser($user);
  }
  public function updateUser($user) {
    parent::$em->getRepository('MDBUserBundle:User')->updateUser();
  }
}
