<?php 

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as valdationType;

class EditAccountForm extends AbstractType
{
	public function buildForm(FormBuilderInterface  $builder, array $options) {
		$builder
		->add('email', 'email', array(
		    'constraints' => array(new valdationType\NotNull(array('message' => 'Enter your email'))) 
		))
		->add('lastname', 'text',  array(
		    'constraints' => array() 
		))
		->add('firstname', 'text', array(
 
		))
		->add('update', 'submit');
	}

	public function getName() { 
        return 'editaccount';
    }
}