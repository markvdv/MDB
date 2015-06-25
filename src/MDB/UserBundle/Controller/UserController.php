<?php

namespace MDB\UserBundle\Controller;

use MDB\UserBundle\Entity\User;
use MDB\UserBundle\Form\Type\LoginType;
use MDB\UserBundle\Form\Type\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

  /**
   * @Route("/",name="user_index")
   * @Template("MDBUserBundle:User:index.html.twig")
   */
  public function indexAction(Request $request) {

    $session = $this->container->get('session');
    $loggedin = $session->get('loggedin');
    if ($loggedin == true && $session->get('role') !== null) {
      return $this->redirect('homepage');
    } else {
      return $this->forward('MDBUserBundle:User:loginUser');
    }
  }

  /**
   * @Route("/login",name="loginUser")
   * @param string $nicknaam
   * @param string $paswoord
   * @return mixed $user:User object/$errors: array met fouten
   */
  public function loginAction(Request $request) {
    $form = $this->createForm(new LoginType(), null, array('action' => $this->generateUrl('loginUser')));
    $form->handleRequest($request);
    if ($form->isValid()) {
      //check of login knop is aangeklikt
      if ($form->get('login')->isClicked()) {
        $nicknaam = $form['nicknaam']->getData();
        $paswoord = $form['paswoord']->getData();
        //niet ontkoppelbaar zo nog aan te passen 
        $model = $this->get("ModelService")->login($nicknaam, $paswoord);
        if (is_object($model)) {
          $this->setSession($model);
          return $this->redirect($this->generateUrl('model_index'));
        } else if (is_array($model)) {
          $errors = $model;
          if ($errors[0]->getCode() == 1) {
            return $this->render("MDBUserBundle:User:index.html.twig", array("form" => $form->createView(), 'errors' => $errors));
          }
        }
        $redacteur = $this->get('RedacteurService')->login($nicknaam, $paswoord);
        if (is_object($redacteur)) {
          $this->setSession($redacteur);
          //nog te raten modellen ophalen en redacteur keuze ggeven om ze te raten
          // $modellen = $this->get("ModelService")->getUnratedModellen();
          return $this->redirect($this->generateUrl('redacteur_index'));
        } else if (is_array($redacteur)) {
          $errors = $redacteur;
          if ($errors[0]->getCode() == 1) {
            return $this->render("MDBUserBundle:User:index.html.twig", array("form" => $form->createView(), 'errors' => $errors));
          }
        }
        $admin = $this->get('AdminService')->login($nicknaam, $paswoord);
        if (is_object($admin)) {
          $this->setSession($admin);
          return $this->redirect($this->generateUrl('admin_index'));
        }
        $errors = $admin;
        return $this->render("MDBUserBundle:User:index.html.twig", array("form" => $form->createView(), 'errors' => $errors));
      } else if ($form->get('registreer')->isClicked()) {
        return $this->redirect($this->generateUrl('model_create'));
      }
    }
    return $this->render("MDBUserBundle:User:index.html.twig", array("form" => $form->createView()));
  }

  /**
   * @Route("/create",name="createUser")
   */
  public function createAction(Request $request) {
    // $form = $this->createFormBuilder()->setMethod('POST')->setAction($this->generateUrl('create_user'))->add('voornaam', 'text')->add('naam', 'text')->add('nicknaam', 'text')->add('paswoord', 'password')->add("email", "email")->add('create', 'submit')->getForm();
    $form = $this->createForm(new RegisterType(), null, array('action' => $this->generateUrl('create_user')));
    $form->handleRequest($request);
    if ($form->isValid()) {
      $voornaam = $form['voornaam']->getData();
      $naam = $form['naam']->getData();
      $nicknaam = $form['nicknaam']->getData();
      $paswoord = $form['paswoord']->getData();
      $email = $form['email']->getData();
      $accesslevel = 0;
      $user = $this->container->get('UserService')->createUser($voornaam, $naam, $nicknaam, $paswoord, $email, $accesslevel);
      if (is_object($user)) {
        $this->setSession($user);
        return $this->redirect($this->generateUrl($this->endPoint));
      } else {
        $errors = $user;
        return $this->render('MDBUserBundle:User:createUser.html.twig', array('form' => $form->createView(), 'errors' => $errors));
      }
    }
    return $this->render('MDBUserBundle:User:createUser.html.twig', array('form' => $form->createView()));
  }

  /**
   * @Route("/loguit",name="loguitUser")
   * @param type $param
   */
  public function logoutAction() {
    $session = $this->get('session');
    $user = new User();
    $user->setNicknaam($session->get('nicknaam'));
    $form = $this->createForm(new LoginType(), $user, array("action" => $this->generateUrl("loginUser")));
    $this->unsetSession();
    return $this->render("MDBUserBundle:User:index.html.twig", array("form" => $form->createView()));
  }

  private function setSession($user) {
    $em = $this->get('doctrine')->getEntityManager();
    $className = $em->getClassMetadata(get_class($user))->getName();
    $session = $this->container->get('session');
    $session->set('loggedin', true);
    $session->set('voornaam', $user->getVoornaam());
    $session->set('naam', $user->getNaam());
    $session->set('accesslvl', $user->getAccesslvl());
    $session->set('id', $user->getId());
    $session->set('email', $user->getEmail());
    $session->set('role', $className);
  }

  private function unsetSession() {
    $session = $this->container->get('session');
    $session->remove('loggedin');
    $session->remove('accesslvl');
    $session->remove('voornaam');
    $session->remove('naam');
    $session->remove('id');
    $session->remove('email');
    $session->remove('role');
  }

}
