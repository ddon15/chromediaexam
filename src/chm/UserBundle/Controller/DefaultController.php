<?php

namespace chm\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/exam")
     * @Template()
     */
    public function indexAction()
    {
        return array('blog_entries' => 'test');
    }

    public function loginAction()
    {
    	return new Response('test');
    }
}
