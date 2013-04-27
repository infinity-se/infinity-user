<?php

namespace InfinityUser\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_reset")
 */
class UserReset
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60, nullable=false)
     */
    private $verification;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $verified;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="InfinityUser\Entity\User", inversedBy="verifications")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;


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
     * Set verification
     *
     * @param string $verification
     * @return UserReset
     */
    public function setVerification($verification)
    {
        $this->verification = $verification;
    
        return $this;
    }

    /**
     * Get verification
     *
     * @return string 
     */
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * Set verified
     *
     * @param \DateTime $verified
     * @return UserReset
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    
        return $this;
    }

    /**
     * Get verified
     *
     * @return \DateTime 
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return UserReset
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set user
     *
     * @param \InfinityUser\Entity\User $user
     * @return UserReset
     */
    public function setUser(\InfinityUser\Entity\User $user)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \InfinityUser\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}