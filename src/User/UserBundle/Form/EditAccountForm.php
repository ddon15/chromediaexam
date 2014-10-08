<?php 

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EditAccountForm extends AbstractType
{
	public function buildForm(FormBuilderInterface  $builder, array $options) {
		$builder
		->add('email', 'email')
		->add('lastname', 'text')
		->add('firstname', 'text')
		->add('password', 'password')
		->add('conpassword', 'password');
	}

	public function getName() { 
        return 'editaccount';
    }
}