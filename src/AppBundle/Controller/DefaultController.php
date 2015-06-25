<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller {

  /**
   * @Route("/", name="homepage")
   * @Security("has_role('ROLE_USER')")
   */
  public function indexAction() {
    $user = $this->get("security.context")->getToken()->getUser();
    $roles = $user->getRoles();
    if (in_array("ROLE_MODEL", $roles)) {
      //redirect naar model profielpagina
      return $this->redirect($this->generateUrl("indexModel"));
    };
    if (in_array("ROLE_REDACTEUR", $roles)) {
      return $this->redirect($this->generateUrl("indexRedacteur"));
    }
    if (in_array('ROLE_ADMIN', $roles)) {
      return $this->redirect($this->generateUrl("indexAdmin"));
    }
  }
}
