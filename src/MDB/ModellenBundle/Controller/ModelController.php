<?php

namespace MDB\ModellenBundle\Controller;

use Doctrine\Common\Util\Debug;
use JMS\Serializer\SerializerBuilder;
use MDB\ModellenBundle\Entity\Adres;
use MDB\ModellenBundle\Entity\Foto;
use MDB\ModellenBundle\Entity\Model;
use MDB\ModellenBundle\Entity\Plaatsnaam;
use MDB\ModellenBundle\Entity\Postcode;
use MDB\ModellenBundle\Form\Type\CreateModelType;
use MDB\ModellenBundle\Form\Type\UpdateModelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ModelController extends Controller {

  /**
   * @Route("/",name="indexModel")
   * @Security("has_role('ROLE_MODEL')")
   * @Template()
   */
  public function indexAction() {
    //model ophalen om te zien of ze al bestaat
    $user = $this->get("security.context")->getToken()->getUser();
    $model = $this->get('modelservice')->findByEmail($user->getEmail());
    if (!$model) {
      return $this->forward("MDBModellenBundle:Model:create");
    }
    $form = $this->createForm(new CreateModelType(), $model, array('action' => $this->generateUrl("model_update", array('id' => $model->getId()))));
    return $this->render('MDBModellenBundle:Model:profiel.html.twig', array('form' => $form->createView(), 'fotos' => $model->getFotos(), 'modelid' => $model->getId()));
  }

  /**
   * @Route("/create",name="model_create")
   * @Security("has_role('ROLE_MODEL')")
   */
  public function createAction(Request $request) {
    $user = $this->get("security.context")->getToken()->getUser();
    $model = new Model();
    $model->setUserName($user->getUserName());
    $model->setEmail($user->getEmail());
    $model->setPassword($user->getPassword());
//    $model->setVoornaam($session->get('voornaam'));
    //   $model->setNaam($session->get('naam'));
    // $model->setEmail($session->get('email'));
    $form = $this->createForm(new CreateModelType(), $model, array("action" => $this->generateUrl('model_create')));
    $form->handleRequest($request);
    if ($form->isValid()) {
      $model = $form->getData();
      echo "<pre>";
      var_dump($model);
      echo "</pre>";
      echo __LINE__ . "<br>" . __FILE__ . "<br>";
//file upload
      for ($i = 0; $i < count($fotos); $i++) {
        $uploadedFile = $fotos[$i];
        $foto = new Foto();
        $name = $uploadedFile->getClientOriginalName();
        $name = preg_replace("/ /", "", $name);
        $foto->setNaam($name);
        $foto->setFile($uploadedFile);
        $foto->setModel($model);
        $model->addFoto($foto);
      }
      $errors = $this->get('ModelService')->createModel($model);
      if ($errors) {
        return $this->render('MDBModellenBundle:Model:create.html.twig', array('form' => $form->createView(), "errors" => $errors));
      }
      $this->setSession($model);
      //return $this->redirect($this->generateUrl("model_update",array('id'=>$model->getId())));
      return $this->forward("MDBModellenBundle:Model:index");
    }
    return $this->render('MDBModellenBundle:Model:create.html.twig', array('form' => $form->createView()));
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

  /**
   * 
   * @Route("/update/{id}",defaults={"id"=null},name="model_update")
   */
  public function updateAction($id, Request $request) {

    $session = $this->container->get('session');
    //check of de user wel is ingelogd
    if ($session->get('loggedin') !== true) {
      return $this->redirect($this->generateUrl("user_index"));
    }
    //check of ide parameter wel dezelfde is als de id die opgeslagen is in de sessie 
    if ($id != $session->get('id')) {
      echo "helaba dees is ni uw profiel!!!";
      die;
    }
    $model = $this->get('ModelService')->findById($id);
    if (!is_object($model)) {
      return $this->redirect($this->generateUrl("model_create"));
    }
    $form = $this->createForm(new UpdateModelType(), $model, array('action' => $this->generateUrl("model_update", array('id' => $id))));
    $form->handleRequest($request);
    if ($form->isvalid()) {
      //model updaten
      $fotos = $form['fotos']->getData();
      if ($fotos[0] !== null) {
        for ($i = 0; $i < count($form['fotos']->getData()); $i++) {
          $uploadedFile = $fotos[$i];
          $foto = new Foto();
          $name = $uploadedFile->getClientOriginalName();
          $foto->setNaam($name);
          $foto->setFile($uploadedFile);
          $foto->setModel($model);
          $model->addFoto($foto);
        }
      }
      $this->get('ModelService')->updateModel($model);
    }
    $fotos = $model->getFotos();
    return $this->render('MDBModellenBundle:Model:update.html.twig', array('form' => $form->createView(), 'fotos' => $fotos));
  }

  /**
   * @Route("/update/ajax/{id}/{params}",defaults={"id"=1,"params"=null},name="model_update_ajax")
   */
  public function updateAjaxAction($id, $params) {
    $model = $this->get('ModelService')->findById($id);
    $arr = array();
    $params = explode('&', $params);
    for ($i = 0; $i < count($params); $i++) {
      $temp = explode('=', $params[$i]);
      $arr[$temp[0]] = $temp[1];

      //$method= "set".ucfirst($temp[0]);
      //  $model->{$method}($temp[1]);
    }
    /*  if (isset($arr['nicknaam'])) {
      $model->setVoornaam($arr['voornaam']);
      $model->setNaam($arr['naam']);
      $model->setNicknaam($arr['nicknaam']);
      // $model->setGeboortedatum($arr['geboortedatum']);
      $adres = $model->getAdres();
      if ($adres == null) {
      $adres = new Adres();
      }
      $model->getAdres()->setStraatnaam();
      $model->getAdres()->setHuisnummer();
      $model->getAdres()->getPlaatsnaam()->setPlaatsnaam();
      $model->getAdres()->getPlaatsnaam()->getPostcode()->setPostcode();
      } */
    if (isset($arr['lengte'])) {
      $model->setLengte($arr['lengte']);
      $model->setGewicht($arr['gewicht']);
      $model->setBorstomtrek($arr['borstomtrek']);
      $model->setTaille($arr['borstomtrek']);
      $model->setHeup($arr['heup']);
      $model->setSchoenmaat($arr['schoenmaat']);
    }
    if (isset($arr['haarkleur'])) {
      $model->setGsm($arr['gsm']);
      $model->setEmail($arr['email']);
      $model->setWebsite($arr['website']);
    }
    echo "<pre>";
    Debug::dump($model);
    echo "</pre>";
    echo __LINE__ . "<br>" . __FILE__ . "<br>";
    $this->get('ModelService')->updateModel($model);
    die;
    $serializer = SerializerBuilder::create()->build();
    $jsonContent = $serializer->serialize($model, 'json');
    return new Response($jsonContent, 200, array('Content-Type' => 'application/json'));
    //}
    //  return new Response();
  }

  /**
   * @Route("/delete/{id}",defaults={"id"=1},name="model_delete")
   * @param integer $id
   */
  public function deleteModel($id) {
    $rootDir = $this->get('kernel')->getRootDir() . "/../web";
    $this->get('ModelService')->deleteModel($id, $rootDir);
    return new Response(json_encode('deleted model with id: ' . $id), 200, array('Content-Type' => 'application/json'));
  }

}
