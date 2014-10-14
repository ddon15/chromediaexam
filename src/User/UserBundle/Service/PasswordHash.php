<?php 
/**
 * Class: PasswordHash
 * @author <divoannie.donayre@chromedia.com>
 * @copyright 2014
 */
namespace User\UserBundle\Service;

//use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class PasswordHash
{

    public function encodePassword($raw)
    {
        return hash('sha256', $raw); // Custom function for password encrypt
    }

    public function isPasswordValid($encoded, $raw)
    {
        return $encoded === $this->encodePassword($raw);
    }

}