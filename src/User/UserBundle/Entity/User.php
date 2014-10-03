<?php 

namespace User\UserBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

class User
{

    protected $id;

    protected $email;

    protected $lastname;

    protected $firstname;

    protected $password;
    
    protected $stat;

   // public function __set($name, $value)
    //{
       // $this->data[$name] = $value;
    //}

    //public function __get($name)
    //{
   //     return $this->data[$name]
   // }
 
    public function getEmail() {
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

    public function getId() {
        return $this->id;
    }

	

    public function setEmail($email) {
        $this->email = $email;
    }

     public function setPassword($password) {
        $this->password = $password;
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

}