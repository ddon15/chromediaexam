<?php 

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangePassForm extends AbstractType
{
	public function buildForm(FormBuilderInterface  $builder, array $options) {
		$builder
		->add('curpassword', 'password')
		->add('newpassword', 'password')
		->add('conpassword', 'password');
	}

	public function getName() { 
        return 'updatePassForm';
    }
}