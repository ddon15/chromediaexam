<?php 

namespace User\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class SignUpUserForm extends AbstractType
{
	public function buildForm(FormBuilderInterface  $builder, array $options) {
		$builder
		->add('email', 'email',  array(
			'attr' => array('class'=>'form-control')
			))
		->add('lastname', 'text', array(
			'attr' => array('class'=>'form-control')
			))
		->add('firstname', 'text',array(
			'attr' => array('class'=>'form-control'),
			))
		->add('password', 'repeated', array(
			'attr' => array('class'=>'form-control'),
			'type' => 'password', 
			'options' => array('attr' => array('class' => 'password-field form-control')),
		    'required' => true,
		    'first_options'  => array('label' => 'Password'),
		    'second_options' => array('label' => 'Repeat Password'),
		    'invalid_message' => 'Password did not match'
			))
		->add('save', 'submit', array(
			'label' => 'Save User',
			'attr' => array('class'=> 'btn btn-success margin-top-10 pull-right')
			));
	}

	public function getName() { 
        return 'signup';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'data_class' => 'User\UserBundle\Entity\User',
	    ));
	}
}