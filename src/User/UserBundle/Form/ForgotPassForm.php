<?php 

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ForgotPassForm extends AbstractType
{
	public function buildForm(FormBuilderInterface  $builder, array $options) {
		$builder
		->add('email', 'email')
		->add('submitemail', 'submit', array('label' => 'Send me an Email'));
	}

	public function getName() { 
        return 'forgotPassForm';
    }
}