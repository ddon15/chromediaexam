<?php 

namespace User\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{

    protected $id;

    protected $email;

    protected $lastname;

    protected $firstname;

    protected $password;
    
    protected $stat;

    protected $salt;

    protected $roles;

    private $isActive;

 
    public function getUsername() {
    	return $this->email;
    }

    public function getPassword() {
    	return $this->password;
    }

    public function getLastname() {
    	return $this->lastname;
    }

    public function getFirstname() {
    	return $this->firstname;
    }

    public function getStat() {
    	return $this->stat;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function getRoles() {
        return array('ROLE_USER');
    }

    public function getId() {
        return $this->id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setSalt($salt) {
        $this->salt = $salt;
    }

     public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setStat($stat) {
        $this->stat = $stat;
    }
    public function setRoles($roles) {
        $this->roles = $roles;
    }
    public function eraseCredentials()
    {

    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

     public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    /**
     * Set is active
     */
    public function setIsActive($active) {
        $this->isActive = $active;
    }

    public function equals(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
