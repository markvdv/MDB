<?php 
namespace MDB\ModellenBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
class RegistrationController extends BaseController
{
  
  
  
    
  /**
   * @Route("/register", name= "model_register")
   * 
   */
    public function registerAction(Request $request)
    {
        $response = parent::registerAction($request);
        // ... do custom stuff
        return $response;
    }
}