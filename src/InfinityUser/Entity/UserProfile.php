<?php

namespace InfinityUser\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_profile")
 */
class UserProfile
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $forename;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(type="date", nullable=true, name="date_of_birth")
     */
    private $dateOfBirth;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=50, nullable=true, name="recovery_answer")
     */
    private $recoveryAnswer;

    /**
     * @ORM\Column(type="string", length=150, nullable=true, name="recovery_question")
     */
    private $recoveryQuestion;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="last_modified")
     */
    private $lastModified;

    /**
     * @ORM\OneToOne(targetEntity="InfinityUser\Entity\User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false, unique=true)
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created      = new \DateTime();
        $this->lastModified = new \DateTime();
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
     * Set name
     *
     * @param string $name
     * @return UserProfile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set forename
     *
     * @param string $forename
     * @return UserProfile
     */
    public function setForename($forename)
    {
        $this->forename = $forename;

        return $this;
    }

    /**
     * Get forename
     *
     * @return string
     */
    public function getForename()
    {
        return $this->forename;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return UserProfile
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return UserProfile
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     * @return UserProfile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return boolean
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return UserProfile
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
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return UserProfile
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set user
     *
     * @param \InfinityUser\Entity\User $user
     * @return UserProfile
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


    /**
     * Set recoveryAnswer
     *
     * @param string $recoveryAnswer
     * @return UserProfile
     */
    public function setRecoveryAnswer($recoveryAnswer)
    {
        $this->recoveryAnswer = $recoveryAnswer;
    
        return $this;
    }

    /**
     * Get recoveryAnswer
     *
     * @return string 
     */
    public function getRecoveryAnswer()
    {
        return $this->recoveryAnswer;
    }

    /**
     * Set recoveryQuestion
     *
     * @param string $recoveryQuestion
     * @return UserProfile
     */
    public function setRecoveryQuestion($recoveryQuestion)
    {
        $this->recoveryQuestion = $recoveryQuestion;
    
        return $this;
    }

    /**
     * Get recoveryQuestion
     *
     * @return string 
     */
    public function getRecoveryQuestion()
    {
        return $this->recoveryQuestion;
    }
}