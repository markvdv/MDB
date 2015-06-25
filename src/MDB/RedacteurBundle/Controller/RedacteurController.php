<?php

namespace MDB\RedacteurBundle\Controller;

use JMS\Serializer\SerializerBuilder;
use MDB\RedacteurBundle\Entity\Rating;
use MDB\RedacteurBundle\Entity\Redacteur;
use MDB\RedacteurBundle\Form\Type\CreateRedacteurType;
use MDB\RedacteurBundle\Form\Type\RatingType;
use MDB\RedacteurBundle\Form\Type\SearchModelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RedacteurController extends Controller {

  /**
   * @Route("/",name="indexRedacteur")
   * @Security("has_role('ROLE_REDACTEUR')")
   * @param type $param
   */
  public function indexAction() {
    $user = $this->get("security.context")->getToken()->getUser();
    $redacteur = $this->get("redacteurService")->findByEmail($user->getEmail());
    $modellen = $this->get('ModelService')->getUnratedModellen($redacteur);
    return $this->render("MDBRedacteurBundle:Redacteur:index.html.twig", array('countUnrated' => count($modellen)));
  }

  /**
   * @Route("/rateOverzicht",name="redacteur_unrated")
   * @Security("has_role('ROLE_REDACTEUR')")
   * haalt de modellen op waar de readacteur nog geen rating op heeft gegeven
   */
  public function unratedModellenAction() {
    $user = $this->get("security.context")->getToken()->getUser();
    $redacteur = $this->get("redacteurService")->findByEmail($user->getEmail());
    $modellen = $this->get('ModelService')->listModellen();
    foreach ($modellen as $key => $model) {
      foreach ($model->getRatings() as $rating) {
        if ($rating->getRedacteur() == $redacteur) {
          unset($modellen[$key]);
        }
      }
    }
    return $this->render("MDBRedacteurBundle:Redacteur:unratedOverzicht.html.twig", array('modellen' => $modellen));
  }

  /**
   * @Route("/rate/{id}",defaults={"id"=1},name="redacteur_rate")
   * @Security("has_role('ROLE_REDACTEUR')")
   * @Template("MDBRedacteurBundle:Redacteur:rateModel.html.twig")
   * @param integer $id
   * @return twigtemplate
   */
  public function rateAction($id, Request $request) {
//model zoeken op basis van id
    $model = $this->get('ModelService')->findById($id);
//fotos om op basis ervan te kunnen oordelen
    $fotos = $model->getFotos();
    $form = $this->createForm(new RatingType());
    $form->handleRequest($request);
    if ($form->isValid()) {
//rating waarde ophalen uit het formulier
      $waarde = $form['ratingNumber']->getData();
      $user= $this->get("security.context")->getToken()->getUser();
      $redacteur= $this->get('redacteurservice')->findByEmail($user->getEmail());
//redacteur id uit de sessie halen
      $rating = $this->get('RedacteurService')->findByRedacteurModel($redacteur, $model);
      if (!$rating) {
        $rating = new Rating();
      }
      $rating->setWaarde($waarde);
      $rating->setModel($model);
      $rating->setRedacteur($redacteur);
      $redacteur->addRating($rating);
      $model->addRating($rating);
      $this->get('ModelService')->updateModel($model);
      return $this->redirect('MDBRedacteurBundle:Redacteur:Index');
    }
//return $this->render("MDBRedacteurBundle:Redacteur:rateModel.html.twig", array('form' => $form->createView(), 'fotos' => $fotos));
    return array('form' => $form->createView(), 'fotos' => $fotos);
  }

  /**
   * @Route("/searchmodel",name="redacteur_model_search")
   * @Security("has_role('ROLE_REDACTEUR')")
   * @param type $param
   * @return type
   */
  public function searchModelAction() {
    $form = $this->createForm(new SearchModelType());
    $modellen = $this->get('ModelService')->listModellen();
    return $this->render("MDBRedacteurBundle:Redacteur:modelSelectie.html.twig", array('form' => $form->createView(), 'modellen' => $modellen));
  }

  /**
   * @Route("/search/{params}",name="redacteur_search",condition="request.headers.get('X-Requested-With') == 'XMLHttpRequest'")
   * @Security("has_role('ROLE_REDACTEUR')")
   */
  public function searchAction($params) {
    $modellen = $this->get('ModelService')->searchModelByParams($params);
// $modellen = $this->get('ModelService')->listModellen();
    $serializer = SerializerBuilder::create()->build();
    $jsonContent = $serializer->serialize($modellen, 'json');
    return new Response($jsonContent, 200, array('Content-Type' => 'application/json'));
  }

  /**
   * @Route("/create",name="redacteur_create")
   * @Security("has_role('ROLE_REDACTEUR')")
   * @param Request $request
   * @return type
   */
  public function createRedacteur(Request $request) {
//form 
    $form = $this->createForm(new CreateRedacteurType);
    $form->handleRequest($request);
    if ($form->isValid()) {
      $redacteur = new Redacteur();
      $redacteur->setNaam($form['naam']->getData())
              ->setvoornaam($form['voornaam']->getData())
              ->setNicknaam($form['nicknaam']->getData())
              ->setEmail($form['email']->getData())
              ->setPaswoord($form['paswoord']->getData());
      $errors = $this->get('RedacteurService')->createRedacteur($redacteur);
      if (is_array($errors) && count($errors) > 0) {
        return $this->render("MDBRedacteurBundle:Redacteur:createRedacteur.html.twig", array('form' => $form->createView(), 'errors' => $errors));
      }
    }
    return $this->render("MDBRedacteurBundle:Redacteur:createRedacteur.html.twig", array('form' => $form->createView()));
  }

  /**
   * @Route("/delete/{id}",defaults={"id"=1},name="redacteur_delete")
   * @Security("has_role('ROLE_REDACTEUR')")
   * @param integer $id
   */
  public function deleteRedacteur($id) {
    $this->get('RedacteurService')->deleteRedacteur($id);
    return new Response(json_encode('deleted redacteur with id: ' . $id), 200, array('Content-Type' => 'application/json'));
  }

}
