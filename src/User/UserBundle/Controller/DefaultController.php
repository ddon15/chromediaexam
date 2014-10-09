<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use User\UserBundle\Form\SignUpUserForm;
use User\UserBundle\Form\LoginForm;
use User\UserBundle\Form\EditAccountForm;
use User\UserBundle\Form\ChangePassForm;
use User\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        $session = new Session();
        $user = $session->get('user');
        if(isset($user)) {
            return $this->redirect($this->generateUrl('dashboard'));
        } else {
        	$form = $this->createForm(new LoginForm());
            return $this->render('UserUserBundle:Default:index.html.twig',  array(
            	'form' => $form->createView(),
            	'error' => '0'
            ));
        }
    }

    public function signupAction() 
    {
    	//$user = new User();
    	$form = $this->createForm(new SignUpUserForm());

    	return $this->render('UserUserBundle:Default:signup.html.twig', array(
			'form' => $form->createView(),
			'error' => '3'
		));
    }

    public function dashboardAction()
    {
       
        $session = new Session();
        $user = $session->get('user');
        $id = $session->get('userid');

        if(isset($user)) {
            $data = [];
            $user = $this->get('user.userbundle.mapper')->searchUserById($id);
            $form = $this->createForm(new EditAccountForm());
            $data['form']  = $form->createView();
        
            if($user) {
                $data['email']  = $user->getUsername();
                $data['lname']  = $user->getLastname();
                $data['fname']  = $user->getFirstname();
            }

    	   return $this->render('UserUserBundle:Default:dashboard.html.twig', $data);

        } else {

            return $this->redirect($this->generateUrl('login'));
        }
    }

    public function changePassAction() 
    {

        $request    = Request::createFromGlobals();
        $form = $this->createForm(new ChangePassForm());
        $method = $request->getMethod();

        if($method == 'POST') {
                //Get current password of user
                $rForm      = $request->request->get('updatePassForm');
                $session = new Session();
                $searchUserCurrentPass = $this->get('user.userbundle.mapper')->searchUserById($session->get('userid')); 
                if($searchUserCurrentPass) {
                    $currentPass = $searchUserCurrentPass->getPassword(); 
                }
                $data = [];
                //Compare Current password to Current password inputted by user
                $passwordInput = $this->get('pw_encoder')->encodePassword($rForm['curpassword']);
                if($currentPass != $passwordInput) {
                    $error = 1;
                    $data['password'] = $rForm['curpassword'];
                } elseif($rForm['newpassword'] != $rForm['conpassword']) {
                    $error = 2;
                    $data['password'] = $rForm['curpassword'];
                } else {
                    $error = 0;
                    $data['password'] = '';
                    $rForm['id'] = $session->get('userid');
                    $rForm['password']= $this->get('pw_encoder')->encodePassword($rForm['newpassword']);
                    $savePass = $this->get('user.userbundle.mapper')->updateUserPass($rForm);
                }
                    
                $data['form'] = $form->createView();
                $data['error'] = $error;
             
                return $this->render('UserUserBundle:Default:changepass.html.twig', $data);

        } else {
            $data['password'] = '';
            $data['form'] = $form->createView();
            $data['error'] = 4;
            return $this->render('UserUserBundle:Default:changepass.html.twig', $data);

        }
    }
}
