<?php

namespace MDB\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MDBUserBundle extends Bundle {

  public function getParent() {
    return "FOSUserBundle";
  }

}
