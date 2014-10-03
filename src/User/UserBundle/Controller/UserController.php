<?php 

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use User\UserBundle\Mapper\UserMapper;

class UserController extends Controller {

	public function checkUserAction()
 	{
 		$request = Request::createFromGlobals();
 		$content = $request->getContent();
 		return new JsonResponse(array('test', 'test'));
 	}

 	public function saveUserAction()
 	{
 		$request = Request::createFromGlobals();
 		$rForm = $request->request->get('signup');
 		
 		try {
 			$save = $this->get('user.userbundle.mapper')->saveUser($rForm);
 			if($save) {
 				return $this->redirect($this->generateUrl('signup'));
 			} else {
 				return 
 			}
 		
 		} catch (Exception $e) {
 			echo $e->getMessage();
 		} 
 		
 	}

 }