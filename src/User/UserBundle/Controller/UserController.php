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
use Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle;


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
 			
 			$stat = $check->getStat();
 			if($stat == 1) {
	 			$session = new Session();
				//$session->start();
				$session->set('user', '1');
				$session->set('userid', $check->getId());
				//print_r(expression)
	 			return $this->redirect($this->generateUrl('dashboard'));
	 		} else {
	 			$form = $this->createForm(new LoginForm());
	 			return $this->render('UserUserBundle:Default:index.html.twig',  array(
			        	'error' => '5',
			        	'form' => $form->createView()
			        ));
	 		}
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
 			//Save user information
			$form = $this->createForm(new SignUpUserForm());
			$save = $this->get('user.userbundle.mapper')->saveUser($rForm);
 			if($save) {
 				$session = new Session();
				
				$session->getFlashBag()->add('saveuser', 1);

				//Send an email
				$rForm['id'] = $save;
		
				$this->sendEmail($rForm);

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

 	/**
 	 * Update user
 	 */

 	public function updateUserAction() 
 	{
 		
 		$request = Request::createFromGlobals();
 		$rForm = $request->request->get('editaccount');
 		
 		try {
 			$session = new Session();
 			$rForm['id'] = $session->get('userid');
 			$update = $this->get('user.userbundle.mapper')->updateUser($rForm);
 			if($update) {
 				$session->getFlashBag()->add('updateuser', 0);
 			} else {
 				$session->getFlashBag()->add('updateuser', 1);
 			}

 			return $this->redirect($this->generateUrl('dashboard'));

 		} catch(Exception $e) {

 			echo $e->getMessage();
 		}
 	}

 	/**
 	 * Update User password
 	 */
 	public function updatePassAction()
 	{
 		$request 	= Request::createFromGlobals();
 		$rForm 		= $request->request->get('updatePassForm');
 		$session = new Session();

 		//Get current password of user
 		$searchUserCurrentPass = $this->get('user.userbundle.mapper')->searchUserById($session->get('userid')); 
 		if($searchUserCurrentPass) {
 			$currentPass = $searchUserCurrentPass->getPassword();
 		}

 		//Compare Current password to Current password inputted by user

 		if($currentPass != $rForm['curpassword']) {
 			$session->getFlashbag()->add('changepassword', 3);
 		} elseif($rForm['newpassword'] != $rForm['conpassword']) {
 			$session->getFlashbag()->add('changepassword', 2);
 		} else {
 			$rForm['id'] = $session->get('userid');
 			$savePass = $this->get('user.userbundle.mapper')->updatePass($rForm);
 			$session->getFlashbag()->add('changepassword', 0);
 		}

 		return $this->redirect($this->generateUrl('changepass'));

 	}

 		/**
	 * Send an verification email
	 */
	public function sendEmail($data) {
		$message = \Swift_Message::newInstance()
	        ->setSubject('Verfication Email')
	        ->setFrom('diovannie.donayre@chromedia.com')
	        ->setTo($data['email'])
	        ->setBody($this->renderView('UserUserBundle:Default:email.html.twig', array(
																						'name' => $data['lastname'], 
																						'id'   => $data['id'],
																						'email' => $data['email']
																						)
				));

	    try{
	    	$this->get('mailer')->send($message);
	  	} catch (Exception $e) {
	  		echo $e->getMessage();
	  	}
	    //return $this->render(...);
	}

	/**
	 * Activate usre account
	 */

	public function activateAccountAction() {
		$request 	= Request::createFromGlobals();
		$form = $this->createForm(new LoginForm());
		$id = $request->query->get('id');
		$activate = $this->get('user.userbundle.mapper')->activateAccount($id);

		if($activate) {
				return $this->render('UserUserBundle:Default:index.html.twig',  array(
		        	'error' => '4',
		        	'form' => $form->createView()
		        ));
		} else {
			return false;
		}
	}
 }