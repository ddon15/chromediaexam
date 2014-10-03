<?php 

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use User\UserBundle\Mapper\UserMapper;
use User\UserBundle\Form\SignUpUserForm;
use User\UserBundle\Form\LoginForm;

class UserController extends Controller {

	public function checkUserAction()
 	{
 		$request = Request::createFromGlobals();
 		$logForm = $request->request->get('login');

 		//Check user from database
 		$check = $this->get('user.userbundle.mapper')->searchUserBy($logForm['email'], $logForm['password']);
 	
 		if(count($check) > 0) {
 			return $this->redirect($this->generateUrl('dashboard'));
 		} else {
 			$form = $this->createForm(new LoginForm());
 			return $this->render('UserUserBundle:Default:index.html.twig',  array(
		        	'error' => '1',
		        	'form' => $form->createView()
		        ));
 		}
 		//return new JsonResponse(array('data', $check));
 	}

 	public function saveUserAction()
 	{
 		
 		$request = Request::createFromGlobals();
 		$rForm = $request->request->get('signup');
 		
 		try {
 			$form = $this->createForm(new SignUpUserForm());
 			$save = $this->get('user.userbundle.mapper')->saveUser($rForm);
 			if($save) {
 				return $this->render('UserUserBundle:Default:signup.html.twig',  array(
		        	'error' => '0',
		        	'form' => $form->createView()
		        ));
 			} else {
 				return $this->render('UserUserBundle:Default:signup.html.twig',  array(
		        	'error' => '1',
		        	'form' => $form->createView()
		        ));
 			}
 		
 		} catch (Exception $e) {
 			echo $e->getMessage();
 		} 
 		
 	}

 }