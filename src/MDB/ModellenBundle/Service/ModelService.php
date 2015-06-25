<?php

namespace MDB\ModellenBundle\Service;

use Exception;

class ModelService extends Service {

  public function __construct($em) {
    parent::__construct($em);
  }

  /**
   * geeft overzicht van alle modellen
   * @param string $nicknaam: nicknaam van de user
   * @param string $paswoord:paswoord van de user
   */
  public function listModellen() {
    $modellen = parent::$em->getRepository('MDBModellenBundle:Model')->findAll();
    return $modellen;
  }

  public function searchModelByParams($params) {
    $arr = array();
    $params = explode('&', $params);
    for ($i = 0; $i < count($params); $i++) {
      $temp = explode('=', $params[$i]);
      $arr[$temp[0]] = $temp[1];
    }
    //$modellen = self::$em->getRepository("MDBModellenBundle:Model")->findBy($arr);
    $modellen = self::$em->getRepository('MDBModellenBundle:Model')->findByParams($arr);
    return $modellen;
  }

  /**
   * @param string $nicknaam
   * @param string $paswoord
   * @param string $naam
   * @param string $voornaam
   * @return array $errors: fouten array
   */
  public function createModel($model) {
    //check of nicknaam of email al geregisgtreerd is
    $test = self::$em->getRepository('MDBModellenBundle:Model')->findOneBy(array('email' => $model->getEmail()));
    if ($test) {
      parent::$errors[] = new Exception("email al geregistreerd ");
    }
    $test = self::$em->getRepository('MDBModellenBundle:Model')->findOneBy(array('username' => $model->getUserName()));
    if ($test) {
      parent::$errors[] = new Exception("nicknaam al geregistreerd ");
    }
    if (count(parent::$errors) > 0) {
      return parent::$errors;
    }
    parent::$em->getRepository('MDBModellenBundle:Model')->create($model);
  }

  /**
   * Plaatst de geuploade fotos in un hun respectievelijke map
   * @param type $fotos array van foto objecten
   * @param type $pathname string met pathname waar de fotos naar verplaatst worden
   */
  public function uploadPictures($fotos, $pathname) {
    for ($i = 0; $i < count($fotos); $i++) {
      rename($fotos[$i]->getPathName(), $pathname . "/" . date('Y-m-d') . $fotos[$i]->getClientOriginalName());
    }
  }

  public function findByNicknaam($nicknaam) {
    $model = self::$em->getRepository('MDBModellenBundle:Model')->findOneBy(array('nicknaam' => $nicknaam));
    return $model;
  }
  public function findByEmail($email) {
    $model = self::$em->getRepository('MDBModellenBundle:Model')->findOneBy(array('email' => $email));
    return $model;
  }

  public function findById($id) {
    $model = self::$em->getRepository('MDBModellenBundle:Model')->findOneBy(array('id' => $id));
    return $model;
  }

  public function deleteModel($id, $rootDir) {
    $model = self::$em->getRepository('MDBModellenBundle:Model')->findOneBy(array('id' => $id));
    foreach ($model->getFotos() as $foto) {
      unlink($rootDir . "/uploads/documents/" . $foto->getpath());
    }
    self::$em->getRepository('MDBModellenBundle:Model')->delete($model);
  }

  public function updateModel($model) {
    self::$em->getRepository('MDBModellenBundle:Model')->update($model);
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
    $model = parent::$em->getRepository('MDBModellenBundle:Model')->findOneBy(array('nicknaam' => $nicknaam));
    if ($model !== null) {
      if ($model->getPaswoord() == hash('sha256', $paswoord . $model->getSalt())) {
        return $model;
      } else {
        parent::$errors[] = new Exception('paswoord incorrect',1);
      }
    } else {
      parent::$errors[] = new Exception('nicknaam niet geregistreerd',0);
    }
    return parent::$errors;
  }

  public function getUnratedModellen($redacteur) {
    $modellen = self::$em->getRepository("MDBModellenBundle:Model")->findAll();
    foreach ($modellen as $key => $model) {
      foreach ($model->getRatings() as $rating) {
        if ($rating->getRedacteur() == $redacteur) {
          unset($modellen[$key]);
        }
      }
    }
    return $modellen;
  }

}
