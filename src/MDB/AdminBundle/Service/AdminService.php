<?php

namespace MDB\AdminBundle\Service;

use Exception;
use MDB\AdminBundle\Entity\Admin;

class AdminService extends Service {

  public function __construct($em) {
    parent::__construct($em);
  }

  /**
   * 
   */
  public function listRedacteurs() {
    $redacteurs = parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->findAll();
    return $redacteurs;
  }

  public function listModellen() {
    $modellen = parent::$em->getRepository('MDBModellenBundle:Model')->findAll();
    return $modellen;
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
    $admin = parent::$em->getRepository('MDBAdminBundle:Admin')->findOneBy(array("nicknaam" => $nicknaam));
    if ($admin) {
      if ($admin->getPaswoord() == hash('sha256', $paswoord . $admin->getSalt())) {
        return $admin;
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
  public function createAdmin($voornaam, $naam, $nicknaam, $paswoord, $email, $accesslevel) {
    $admin = parent::$em->getRepository('MDBAdminBundle:Admin')->findOneBy(array('nicknaam' => $nicknaam));
    if ($admin) {
      parent::$errors[] = new Exception("nicknaam al geregistreerd");
    } else {
      $admin = new Admin();
      $salt = bin2hex(openssl_random_pseudo_bytes(mt_rand(40, 50))); //random salt
      $paswoord = hash('sha256', $paswoord . $salt);
      $admin->setNicknaam($nicknaam)->setNaam($naam)->setVoornaam($voornaam)->setPaswoord($paswoord)->setSalt($salt)->setEmail($email)->setAccesslvl($accesslevel);
      parent::$em->getRepository('MDBAdminBundle:Admin')->createUser($admin);
      return $admin;
    }
    return parent::$errors;
  }

  public function deleteAdmin($admin) {
    parent:$em->getRepository('MDBAdminBundle:Admin')->deleteAdmin($user);
  }

  public function updateAdmin($admin) {
    parent::$em->getRepository('MDBAdminBundle:Admin')->updateAdmin();
  }

  public function getByNicknaam($nicknaam) {
    $admin = self::$em->getRepository('MDBAdminBundle:Admin')->findBy(array('nicknaam' => $nicknaam));
    return $admin;
  }

}
