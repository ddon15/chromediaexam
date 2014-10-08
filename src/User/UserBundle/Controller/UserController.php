<?php 

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use User\UserBundle\Mapper\UserMapper;
use User\UserBundle\Form\SignUpUserForm;
use User\UserBundle\Form\LoginForm;
use Symfony\Component\HttpFoundation\Session\Session;


class UserController extends Controller {

	public function checkUserAction()
 	{
 		$request = Request::createFromGlobals();
 		$logForm = $request->request->get('login');

 		// echo $logForm['email'] . '-' . $this->get('pw_encoder')->encodePassword($logForm['password']); die();
 																	
 		//Check user from database
 		$check = $this->get('user.userbundle.mapper')->searchUserBy($logForm['email'], 
 																	$this->get('pw_encoder')
 																	->encodePassword($logForm['password']));

 		if(count($check) > 0) {
 			$session = new Session();
			//$session->start();
			$session->set('user', '1');
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
 		//$session = $request->getSession();
 		$rForm = $request->request->get('signup');
 		$password = $rForm['password'];
 		// $salt = uniqid(mt_rand());
 		//Hash password
 		$rForm['password'] = $this->get('pw_encoder')->encodePassword($password);
 		try {
 			$form = $this->createForm(new SignUpUserForm());
 			$save = $this->get('user.userbundle.mapper')->saveUser($rForm);
 			if($save) {
 				$session = new Session();
				//$session->start();
				$session->getFlashBag()->add('saveuser', 1);
 				return $this->redirect($this->generateUrl('signup'));
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

 	/**
 	 * Logout user
 	 */
 	public function logoutUserAction() 
 	{
 		$session = new Session();
 		$session->invalidate();
 		return $this->redirect($this->generateUrl('login'));
 	}

 }