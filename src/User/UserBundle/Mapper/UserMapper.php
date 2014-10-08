<?php 
namespace User\UserBundle\Mapper;

use User\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use User\UserBundle\Services\PasswordHash;

class UserMapper{

	protected $em;
	protected $pwHash;

	public function __construct(EntityManager $em) {
		$this->em = $em;
		//$this->pwHash = $pwHash;
	}
	/**
	 * Save User to database
	 * @param array of user info
	 */
	
	public function saveUser($data) {
		$user = new User();
		//$encoder = $this->get('pw_encoder')
  		// ->getEncoder($user);
  		//$password = $encoder->encodePassword($data['password']);
		//Set user data
		$user->setEmail($data['email']);
		$user->setPassword($data['password']);
		$user->setLastname($data['lastname']);
		$user->setFirstname($data['firstname']);
		$user->setStat($data['email']);
		// $user->setSalt($data['salt']);
		$this->em->persist($user);
		$this->em->flush();

		$save = $user->getId();
		if(!$save) {
			throw new exception('Unable to create new user');
		} else {
			return $save;
		}

	}

	/**
	 * Update user to database
	 * @param array of user info
	 */

	public function updateUser($data) {

	}

	/**
	 * Search user bu username and password for login functionalites from database
	 * @param String Usernamen and Password
	 */

	public function searchUserBy($email, $password) {
		 $user = $this->em
        ->getRepository('UserUserBundle:User')
        ->findOneBy(array(
        	'email' => $email,
        	'password' => $password));
  
		return $user;
	}

}