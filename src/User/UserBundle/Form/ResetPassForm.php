<?php 

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ResetPassForm extends AbstractType
{
	public function buildForm(FormBuilderInterface  $builder, array $options) {
		$builder
		->add('newpassword', 'password')
		->add('conpassword', 'password');
	}

	public function getName() { 
        return 'resetPassForm';
    }
}