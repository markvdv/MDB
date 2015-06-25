<?php

namespace MDB\AdminBundle\Service;

class Service {

  protected static $em;
  protected static $errors; //array om de exceptions op te vangen

  public function __construct($em) {
    self::$em = $em;
    self::$errors=array();
  }

  static function getEm() {
    return self::$em;
  }

  static function getErrors() {
    return self:: $errors;
  }

}
