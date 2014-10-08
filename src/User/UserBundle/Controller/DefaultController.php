<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use User\UserBundle\Form\SignUpUserForm;
use User\UserBundle\Form\LoginForm;
use User\UserBundle\Form\EditAccountForm;
use User\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;


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
        $form = $this->createForm(new EditAccountForm());
        $session = new Session();
        $user = $session->get('user');
        if(isset($user)) {
    	   return $this->render('UserUserBundle:Default:dashboard.html.twig', array('form' =>   $form->createView()));
        } else {
            return $this->redirect($this->generateUrl('login'));
        }
    }
}
