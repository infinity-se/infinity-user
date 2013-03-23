<?php

namespace InfinityUser\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_email")
 */
class UserEmail
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=150, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    private $verification;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $verified = null;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="InfinityUser\Entity\User", inversedBy="emails")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created = new \DateTime();
    }

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
     * Set email
     *
     * @param string $email
     * @return UserEmail
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
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

    /**
     * Set verification
     *
     * @param string $verification
     * @return UserEmail
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
     * @return UserEmail
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
     * @return UserEmail
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
     * @return UserEmail
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