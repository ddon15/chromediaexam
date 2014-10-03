<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use User\UserBundle\Form\SignUpUserForm;
use User\UserBundle\Form\LoginForm;


class DefaultController extends Controller
{
    public function indexAction()
    {
    	$form = $this->createForm(new LoginForm());
        return $this->render('UserUserBundle:Default:index.html.twig',  array(
        	'form' => $form->createView(),
        	'error' => '0'
        ));
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
    	return $this->render('UserUserBundle:Default:dashboard.html.twig');
    }
}
