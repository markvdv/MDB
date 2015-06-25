<?php

namespace MDB\RedacteurBundle\Service;

use Exception;

class RedacteurService extends Service {

  public function __construct($em) {
    parent::__construct($em);
  }

  /**
   * 
   */
  public function listUsers() {
    $users = parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->getAll();
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
    $user = parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->findOneBy(array('nicknaam' => $nicknaam));
    if ($user) {
      if ($user->getPaswoord() == hash('sha256', $paswoord . $user->getSalt())) {
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
  public function createRedacteur($redacteur) {
    $test = parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->findOneBy(array('nicknaam' => $redacteur->getNicknaam()));
    if ($test) {
      parent::$errors[] = new Exception("nicknaam al geregistreerd");
    }
    $test = parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->findOneBy(array('email' => $redacteur->getEmail()));
    if ($test) {
      parent::$errors[] = new Exception("email al geregistreerd");
    }

    if (count(parent::$errors) > 0) {
      return parent::$errors;
    }
    $salt = bin2hex(openssl_random_pseudo_bytes(mt_rand(40, 50))); //random salt
    $redacteur->setSalt($salt);
    $paswoord = hash('sha256', $redacteur->getPaswoord() . $salt);
    $redacteur->setPaswoord($paswoord);
    $redacteur->setAccesslvl(1);
    parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->create($redacteur);
    return $redacteur;
  }

  public function deleteRedacteur($id) {
    $redacteur=parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->findOneBy(array('id'=>$id));
    parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->delete($redacteur);
  }

  public function updateRedacteur($redacteur) {
    parent::$em->getRepository('MDBRedacteurBundle:Redacteur')->update($redacteur);
  }

  public function getByNicknaam($nicknaam) {
    $admin = self::$em->getRepository('MDBRedacteurBundle:Redacteur')->findOneBy(array('nicknaam' => $nicknaam));
    return $admin;
  }

  public function findById($id) {
    $redacteur = self::$em->getRepository('MDBRedacteurBundle:Redacteur')->findOneBy(array('id' => $id));
    return $redacteur;
  }

  public function findByEmail($email) {
    $redacteur = self::$em->getRepository('MDBRedacteurBundle:Redacteur')->findOneBy(array('email' => $email));
    return $redacteur;
  }

  public function findByRedacteurModel($redacteur, $model) {
    $rating = self::$em->getRepository('MDBRedacteurBundle:Rating')->findOneBy(array('redacteur' => $redacteur, 'model' => $model));
    return $rating;
  }

}
