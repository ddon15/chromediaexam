<?php 
namespace User\UserBundle\Mapper;

use User\UserBundle\Entity\UserCofirmation;
use Doctrine\ORM\EntityManager;
use User\UserBundle\Services\PasswordHash;


class UserConfirmationMapper{

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
	
	public function saveUser($id) {
		$user = new UserConfirmation();
		$user->setUserId($id);
		$this->em->persist($user);
		$this->em->flush();

		$save = $user->getId();
		if(!$save) {
			throw new exception('Unable to create new user confirmation');
		} else {
			return $save;
		}

	}

	/**
	 * Update user to database
	 * @param array of user info
	 */

	public function updateUser($data) {

		$user = $this->em->getRepository('UserUserBundle:User')->find($data['id']);

		if(!$user) {
			throw $this->createNotFoundException(
            	'No user found for id '.$data['id']
        	);
		}
		//$user->setPassword($data['password']);
		$user->setLastname($data['lastname']);
		$user->setFirstname($data['firstname']);
		$user->setStat(0);
		$this->em->flush();

		return true;
	}

	/**
	 * Search user bu username and password for login functionalites from database
	 * @param String Usernamen and Password
	 */

	public function searchUserBy($email) {
		 $user = $this->em
        ->getRepository('UserUserBundle:UserConfirmation')
        ->findOneBy(array(
        	'email' => $email));
  
		return $user;
	}

	/**
	 * Search user by id
	 * @param Int id
	 */

	public function searchUserById($id) {

		$ufind = $this->em->getRepository('UserUserBundle:User')->find($id);
		if($ufind) {
			return $ufind;
		} else {
			return false;
		}
	} 

	/**
	 * Update User Password
	 * @param Array of data user info
	 */

	public function updateUserPass($data) {

		$user = $this->em->getRepository('UserUserBundle:User')->find($data['id']);

		if(!$user) {
			throw $this->createNotFoundException(
            	'No user found for id '.$data['id']
        	);
		}
		$user->setPassword($data['password']);
		
		$this->em->flush();

		return true;
	}

	/**
	 * Activate account
	 * @param Int id
	 */
	public function activateAccount($id) {
		$user = $this->em->getRepository('UserUserBundle:User')->find($id);

		if(!$user) {
			throw $this->createNotFoundException(
            	'No user found for id '.$data['id']
        	);
		} else {
			if($user->getStat() == 1) {
				throw $this->createNotFoundException(
            	'User is already activated'
        		);
		   }
		}
		$user->setStat(1);
		$this->em->flush();

		return true;
	}

}