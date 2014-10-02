<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserUserBundle:Default:index.html.twig');
    }

    public function signupAction() 
    {
    	return $this->render('UserUserBundle:Default:signup.html.twig');
    }

    public function dashboardAction()
    {
    	return $this->render('UserUserBundle:Default:dashboard.html.twig');
    }
}
