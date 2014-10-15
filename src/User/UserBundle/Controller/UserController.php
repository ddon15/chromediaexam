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

 	/**
 	 * Update user
 	 */

 	public function updateUserAction() 
 	{
 		
 		$request = Request::createFromGlobals();
 		$rForm = $request->request->get('editaccount');
 		
 		try {
 			$user = $this->get('security.context')->getToken()->getUser();
 			$session = new Session();
 			$rForm['id'] = $user->getId();
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
	 * Send an Reset password link
	 */
	public function sendEmailToResetPassword($data) {
		$uid 		= $data['uid'];
		$id 		= $data['id'];
		$authcode 	= $data['authcode'];

		$request 	= Request::createFromGlobals();
		$url 		= $this->generateUrl('resetpassword', array('id' => $id, 'authcode' => $authcode), true);
		
		$message = \Swift_Message::newInstance()
	        ->setSubject('Reset Password')
	        ->setFrom('diovannie.donayre@chromedia.com')
	        ->setTo($data['email'])
	        ->setBody($this->renderView('UserUserBundle:Default:resetemail.html.twig', array(
																						'name' => $data['firstname'], 
																						'email' => $data['email'],
																						'url' => $url
																						)
				));

	    try{
	    	$send = $this->get('mailer')->send($message);
	    	if($send) {
	    		return true;
	    	} else {
	    		return false;
	    	}
	  	} catch (Exception $e) {
	  		echo $e->getMessage();
	  	}
	    //return $this->render(...);
	}

	

	public function saveUserConfirmationAction() {
		$request 	= Request::createFromGlobals();
		$rForm		= $request->request->get('forgotPassForm');
		
		$isUser 			= $this->get('user.userbundle.mapper')->searchUserByEmail($rForm['email']);
		$rForm['uid'] 		= $isUser->getId();
		
		if($isUser) {
			$save = $this->get('user.userbundle.mapper')->saveUserConfirmation($isUser->getId());
			//print_r($save); exit;
			if($save) {
				$rForm['id'] 		= $save->getId();
				$rForm['uid'] 		= $isUser->getId();
				$rForm['authcode'] 	= $save->getAuthCode();
				$rForm['firstname'] = $isUser->getFirstname();

				//Send Reset Email
				$sendEmail = $this->sendEmailToResetPassword($rForm);
				if($sendEmail) {
					return new JsonResponse(array('error' => 0, 'msg' => 'Successfully save. Please check your email'));
				} else {
					return new JsonResponse(array('error' => 1, 'msg' => 'Errror sending email'));
				}
			} else {
				return new JsonResponse(array('error' => 1, 'msg' => 'Errror savaing User confimration info'));
			}
		} else {
			return new JsonResponse(array('error' => 1, 'msg' => 'Email was not found.'));
		}
	
	}
 }