<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use User\UserBundle\Form\SignUpUserForm;
use User\UserBundle\Form\LoginForm;
use User\UserBundle\Form\EditAccountForm;
use User\UserBundle\Form\ChangePassForm;
use User\UserBundle\Form\ForgotPassForm;
use User\UserBundle\Form\ResetPassForm;
use User\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    public function indexAction(Request $req)
    {

        $request = $this->getRequest();
        $session = $request->getSession();
      //  var_dump($request); exit;

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
         return $this->redirect($this->generateUrl('dashboard'));
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        $form = $this->createForm(new LoginForm());
        //var_dump($error);
        $nya = '' ;
        if($req->query->get('nya')) {
            $nya = 1;
        }
        return $this->render(
            'UserUserBundle:Default:index.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error'         => $error,
                'form' => $form->createView(),
                'nya' => $nya
            )
        );
    }

    public function signupAction(Request $request) 
    {
    	$user = new User();
    	$form = $this->createForm(new SignUpUserForm(), $user);
        $form->handleRequest($request);
        $rform = $request->request->get('signup');
        $salt = md5(uniqid());
        $user->setSalt($salt);
        //Decode password
        $user->setPassword($this->get('security.encoder_factory')->getEncoder($user)->encodePassword($rform['password']['first'], $salt));

        if($form->isValid()) {
            $save = $this->get('user.userbundle.mapper')->saveUser($user);
            if($save) {
                $session = new Session();
                
                $data = [
                    'email'     => $rform['email'],
                    'id'        => $save,
                    'firstname' => $rform['firstname']
                ];
                //Send email
                $sendEmail = $this->sendEmail($data);
                if($sendEmail) {
                    $session->getFlashBag()->add('saveuser', 0);
                } else {
                    $session->getFlashBag()->add('saveuser', 1);
                }
                return $this->redirect($this->generateUrl('signup'));
            } else {

            }
        } else {

        return $this->render('UserUserBundle:Default:signup.html.twig', array(
            'form' => $form->createView(),
            'error' => '3'
        ));
        }

    
    }

    public function dashboardAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $lname = $user->getLastname();
        $fname = $user->getFirstname();
        $email= $user->getUsername();
        $stat= $user->getStat();

        if($stat == 0) {
            $session = new Session();
            $session->set('notyetactivated', 1);
            return $this->redirect($this->generateUrl('logout'));
        }

        $data['email']  = $email;
        $data['lname']  = $lname;
        $data['fname']  = $fname;
        $form = $this->createForm(new EditAccountForm());
        $data['form']  = $form->createView();
        return $this->render('UserUserBundle:Default:dashboard.html.twig', $data);
      
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

    public function forgotPassAction()
    {
        $form = $this->createForm(new ForgotPassForm());
        $data['form'] = $form->createView();
        $data['error'] = 4;
        return $this->render('UserUserBundle:Default:forgotpass.html.twig', $data);
    }

    public function testAction() 
    {
$user = new User();
//var_dump($user); exit;    
        var_dump($this->get('security.encoder_factory')->getEncoder($user)->encodePassword('password', null)); exit;
        $request    = Request::createFromGlobals();
        echo $request->server->get('HTTP_HOST');
        $date = date("Y-m-d H:i:s");
        echo $date . 'test';
        die(' This is testing pages');
      
    }

    public function resetPassAction() 
    {
        $form = $this->createForm(new ResetPassForm());
        $request    = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $method = $request->getMethod();
        $data = [];
        $data['form'] = $form->createView();
        $id = $request->query->get('id');
        $authcode= $request->query->get('authcode');
        $checkResetId = $this->get('user.userbundle.mapper')->searchConUser($id, $authcode); 
        $dateNow = date('m/d/Y');
        $dateSend = date('m/d/Y', strtotime($checkResetId->getDateSend()));
        $dateDiff = $this->dateDiff($dateNow, $dateSend);
      
        if($checkResetId) {
            if($checkResetId->getConfirmed() == 1 || $dateDiff > 1 ) {
                $data['error'] = 5;
                $session = new Session();
                $session->getFlashBag()->add('resetlinkexpired', 1);
                return $this->redirect($this->generateUrl('login'));
            } 
        }
            if($method == 'POST') {
                $rForm = $request->request->get('resetPassForm');
            
                $pw =  $rForm['newpassword'];
                $conpw = $rForm['conpassword'];
                $searchConUser= $this->get('user.userbundle.mapper')->searchConUser($id, $authcode); 
     
                if($searchConUser) {
                    //Update confirmation
                    $searchConUser->setConfirmed(1);
                    $update = $em->flush();
                    //Update password
                    if($pw != $conpw) {
                        $data['error'] = 2;
                        return $this->render('UserUserBundle:Default:resetpass.html.twig', $data);
                    }
                    $dataPass['id']         = $searchConUser->getUserId();
                    $dataPass['password']   = $this->get('pw_encoder')->encodePassword($pw);

                    $updatePassword= $this->get('user.userbundle.mapper')->updateUserPass($dataPass); 
                    if($updatePassword) {
                        $data['error'] = 0;
                    } else  {
                        $data['error'] = 3;
                    }
                    return $this->render('UserUserBundle:Default:resetpass.html.twig', $data);
                    
                } else {
                    $data['error'] = 1;
                    return $this->render('UserUserBundle:Default:resetpass.html.twig', $data);
                }

            } else {
              
                $data['error'] = 4;
                $data['id'] = $id;
                $data['authcode'] = $authcode;
                return $this->render('UserUserBundle:Default:resetpass.html.twig', $data);
            }
       
    }

    /**
     * Send an verification email
     */
    public function sendEmail($data) 
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Verfication Email')
            ->setFrom('diovannie.donayre@chromedia.com')
            ->setTo($data['email'])
            ->setBody($this->renderView('UserUserBundle:Default:email.html.twig', array(
                                                                                        'name' => $data['firstname'], 
                                                                                        'id'   => $data['id'],
                                                                                        'email' => $data['email']
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

    /**
     * Activate user account
     */

    public function activateAccountAction() 
    {
        $request    = Request::createFromGlobals();
        $form = $this->createForm(new LoginForm());
        $id = $request->query->get('id');
        
        $activate = $this->get('user.userbundle.mapper')->activateAccount($id);
        $session = new Session();
        if($activate) {
            $session->getFlashBag()->add('activated', 1);
        } else {
            $session->getFlashBag()->add('notactivated', 1);
        }
        return $this->redirect('login');
    }

    public function dateDiff($date1p, $date2p) {
        $date1 = new \DateTime($date1p);
        $date2 = new \DateTime($date2p);
        return $date1->diff($date2)->format("%d");
    }
}
