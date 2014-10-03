<?php 

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
	public function buildForm(FormBuilderInterface  $builder, array $options) {
		$builder
		->add('email', 'email')
		->add('password', 'password');
	}

	public function getName() { 
        return 'username';
    }
}