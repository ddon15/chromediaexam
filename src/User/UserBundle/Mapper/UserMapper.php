<?php 
namespace User\UserBundle\Mapper;

use User\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;


class UserMapper{

	protected $em;

	public function __construct(EntityManager $em) {
		$this->em = $em;
	}
	/**
	 * Save User to database
	 * @param array of user info
	 */
	
	public function saveUser($data) {
		$user = new User();
		
		//Set user data
		$user->setEmail($data['email']);
		$user->setPassword($data['password']);
		$user->setLastname($data['lastname']);
		$user->setFirstname($data['firstname']);
		$user->setStat($data['email']);
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

	public 
}