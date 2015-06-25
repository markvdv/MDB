<?php

namespace MDB\AdminBundle\Controller;

use MDB\ModellenBundle\Entity\Model;
use MDB\ModellenBundle\Form\Type\SearchModelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller {

  /**
   * @Route("/",name="indexAdmin")
   * @Security("has_role('ROLE_ADMIN')")
   */
  public function indexAction() {
    $redacteurs = $this->get('AdminService')->listRedacteurs();
    $modellen = $this->get('AdminService')->listModellen();
    return $this->render("MDBAdminBundle:Admin:adminpaneel.html.twig", array('redacteurs' => $redacteurs, 'modellen' => $modellen));
    /*   $session = $this->container->get('session');
      //check of de user wel is ingelogd
      if ($session->get('loggedin') != true) {
      return $this->redirect($this->generateUrl("user_index"));
      }
      switch ($session->get('role')) {
      case "MDB\ModellenBundle\Entity\Model":
      $model = $this->get("ModelService")->findById($session->get('id'));
      if ($model) {
      return $this->forward("MDBModellenBundle:Model:update", array('id' => $model->getId()));
      } else {
      return $this->forward("MDBModellenBundle:Model:create");
      }
      break;
      case "MDB\RedacteurBundle\Entity\Redacteur":
      return $this->redirect($this->generateUrl('redacteur_index'));
      break;
      case "MDB\AdminBundle\Entity\Admin":
      $redacteurs= $this->get('AdminService')->listRedacteurs();
      $modellen= $this->get('AdminService')->listModellen();
      return $this->render("MDBAdminBundle:Admin:adminpaneel.html.twig",array('redacteurs'=>$redacteurs,'modellen'=>$modellen));
      break;
      } */
  }

  /**
   * @Route("/login",name="admin_login")
   * @param string $nicknaam
   * @param string $paswoord
   * @return mixed $user:User object/$errors: array met fouten
   */
  public function loginAction(Request $request) {
    $form = $this->createFormBuilder()->setMethod('POST')
            ->setAction($this->generateUrl('login'))
            ->add('nicknaam', 'text')
            ->add('paswoord', 'password')
            ->add('login', 'submit')
            ->add('registreer', 'submit')
            ->getForm();
    $form->handleRequest($request);
    if ($form->isValid()) {
      if ($form->get('login')->isClicked()) {
        $nicknaam = $form['nicknaam']->getData();
        $paswoord = $form['paswoord']->getData();
        $admin = $this->get('AdminService')->login($nicknaam, $paswoord);
        if (is_object($admin)) {
          $this->setSession($admin);
          return $this->forward("admin_index");
        } else if (is_array($admin)) {
          $errors = $admin;
          return $this->render("MDBAdminBundle:Admin:index.html.twig", array("form" => $form->createView(), "errors" => $errors));
        }
      }
    }
    return $this->render("MDBAdminBundle:Admin:index.html.twig", array("form" => $form->createView()));
  }

  private function setSession($user) {
    $session = $this->container->get('session');
    $session->set('loggedin', true);
    $session->set('voornaam', $user->getVoornaam());
    $session->set('naam', $user->getNaam());
    $session->set('accesslvl', $user->getAccesslvl());
    $session->set('id', $user->getId());
    $session->set('email', $user->getEmail());
  }

  private function unsetSession() {
    $session = $this->container->get('session');
    $session->remove('loggedin');
    $session->remove('accesslvl');
    $session->remove('voornaam');
    $session->remove('naam');
    $session->remove('id');
    $session->remove('email');
  }

}
