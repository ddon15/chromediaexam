<?php

namespace User\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStatus
 */
class UserConfirmation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $confirmed;
    
    private $dateSend;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return UserStatus
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set stat
     *
     * @param integer $stat
     * @return UserStatus
     */
    public function setStat($stat)
    {
        $this->stat = $stat;

        return $this;
    }

    /**
     * Get stat
     *
     * @return integer 
     */
    public function getStat()
    {
        return $this->stat;
    }

    /**
     * Set confirmed
     *
     * @param integer $confirmed
     * @return UserConfirmation
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return integer 
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Set dateSend
     *
     * @param string $dateSend
     * @return UserConfirmation
     */
    public function setDateSend($dateSend)
    {
        $this->dateSend = $dateSend;

        return $this;
    }

    /**
     * Get dateSend
     *
     * @return string 
     */
    public function getDateSend()
    {
        return $this->dateSend;
    }
}
