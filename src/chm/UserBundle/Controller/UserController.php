<?php 

namespace chm\UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class UserController extends Controller {
	/**
     * @Route("/user")
     * @Template()
     */
    public function indexAction()
    {
       
    }
    
    public function loginAction()
    {
    	return new Response('<h1>Contact us!</h1>');
    }

}