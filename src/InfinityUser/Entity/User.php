<?php

namespace InfinityUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping AS ORM;
use Zend\Math\Rand;
use ZfcUser\Entity\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $banned;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @ORM\Column(type="datetime", nullable=false, name="last_modified")
     */
    private $lastModified;

    /**
     * @ORM\OneToOne(targetEntity="InfinityUser\Entity\UserEmail", cascade={"persist"})
     * @ORM\JoinColumn(name="primary_email_id", referencedColumnName="id", unique=true)
     */
    private $primaryEmail;

    /**
     * @ORM\OneToOne(targetEntity="InfinityUser\Entity\UserProfile", mappedBy="user", cascade={"persist"})
     */
    private $profile;

    /**
     * @ORM\OneToMany(targetEntity="InfinityUser\Entity\UserReset", mappedBy="user")
     */
    private $verifications;

    /**
     * @ORM\OneToMany(targetEntity="InfinityUser\Entity\UserPassword", mappedBy="user", cascade={"persist"})
     */
    private $passwords;

    /**
     * @ORM\OneToMany(targetEntity="InfinityUser\Entity\UserEmail", mappedBy="user")
     */
    private $emails;

    /**
     * @ORM\ManyToOne(targetEntity="InfinityUser\Entity\UserState", inversedBy="users")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     */
    private $state;

    /**
     * @ORM\ManyToMany(targetEntity="InfinityRbac\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(
     *     name="user_role",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="InfinityAccounts\Entity\Account", inversedBy="users")
     * @ORM\JoinTable(
     *     name="user_account",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)},
     *     inverseJoinColumns={@ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false)}
     * )
     */
    private $accounts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->created      = new \DateTime();
        $this->lastModified = new \DateTime();
        $this->passwords    = new ArrayCollection();
        $this->emails       = new ArrayCollection();
        $this->roles        = new ArrayCollection();
        $this->accounts     = new ArrayCollection();
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
     * Set banned
     *
     * @param \DateTime $banned
     * @return User
     */
    public function setBanned(\DateTime $banned)
    {
        $this->banned = $banned;

        return $this;
    }

    /**
     * Get banned
     *
     * @return \DateTime
     */
    public function getBanned()
    {
        return $this->banned;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated(\DateTime $created)
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
     * @return User
     */
    public function setLastModified(\DateTime $lastModified)
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
     * Set primaryEmail
     *
     * @param UserEmail $primaryEmail
     * @return User
     */
    public function setPrimaryEmail(UserEmail $primaryEmail = null)
    {
        $this->primaryEmail = $primaryEmail;

        return $this;
    }

    /**
     * Get primaryEmail
     *
     * @return UserEmail
     */
    public function getPrimaryEmail()
    {
        return $this->primaryEmail;
    }

    /**
     * Set profile
     *
     * @param UserProfile $profile
     * @return User
     */
    public function setProfile(UserProfile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return UserProfile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Add passwords
     *
     * @param UserPassword $passwords
     * @return User
     */
    public function addPassword(UserPassword $passwords)
    {
        $this->passwords[] = $passwords;

        return $this;
    }

    /**
     * Remove passwords
     *
     * @param UserPassword $passwords
     */
    public function removePassword(UserPassword $passwords)
    {
        $this->passwords->removeElement($passwords);
    }

    /**
     * Get passwords
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPasswords()
    {
        return $this->passwords;
    }

    /**
     * Add emails
     *
     * @param UserEmail $emails
     * @return User
     */
    public function addEmail(UserEmail $emails)
    {
        $this->emails[] = $emails;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param UserEmail $emails
     */
    public function removeEmail(UserEmail $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Set state
     *
     * @param UserState $state
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return UserState
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Add roles
     *
     * @param \InfinityRbac\Entity\Role $roles
     * @return User
     */
    public function addRole(\InfinityRbac\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \InfinityRbac\Entity\Role $roles
     */
    public function removeRole(\InfinityRbac\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Add accounts
     *
     * @param \InfinityAccounts\Entity\Account $accounts
     * @return User
     */
    public function addAccount(\InfinityAccounts\Entity\Account $accounts)
    {
        $this->accounts[] = $accounts;

        return $this;
    }

    /**
     * Remove accounts
     *
     * @param \InfinityAccounts\Entity\Account $accounts
     */
    public function removeAccount(\InfinityAccounts\Entity\Account $accounts)
    {
        $this->accounts->removeElement($accounts);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /* ZFCUSER PROXY METHODS */

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        $email = $this->getPrimaryEmail();
        if ($email instanceof UserEmail) {
            return $email->getEmail();
        }
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        $profile = $this->getProfile();
        if ($profile instanceof UserProfile) {
            return $profile->getName();
        }
    }

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        $profile = $this->getProfile();
        if ($profile instanceof UserProfile) {
            $displayName = $profile->getForename();
            if ($displayName) {
                $displayName .= ' ';
            }
            $displayName .= $profile->getSurname();

            return $displayName;
        }
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        // Load current password
        $criteria = Criteria::create()
                ->orderBy(array('created' => 'DESC'))
                ->setMaxResults(1);
        $search   = $this->passwords->matching($criteria);

        // Check search
        if ($search instanceof ArrayCollection && count($search) === 1 && $search[0] instanceof UserPassword) {
            return $search[0]->getPassword();
        }
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        // Create email
        $userEmail = new UserEmail();
        $userEmail->setCreated(new \DateTime());
        $userEmail->setEmail($email);
        $userEmail->setUser($this);
        $userEmail->setVerification(Rand::getString(16));

        // Set email
        $this->addEmail($userEmail);
        $this->setPrimaryEmail($userEmail);

        return $this;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        // Get profile
        $userProfile = $this->getProfile();
        if (!$userProfile instanceof UserProfile) {
            $userProfile = new UserProfile();
            $userProfile->setCreated(new \DateTime());
            $userProfile->setUser($this);
            $this->setProfile($userProfile);
        }

        // Set username
        $userProfile->setName($username);
        $userProfile->setLastModified(new \DateTime());

        return $this;
    }

    /**
     * Set display name
     *
     * @param string $displayName
     * @return User
     */
    public function setDisplayName($displayName)
    {
        // Get profile
        $userProfile = $this->getProfile();
        if (!$userProfile instanceof UserProfile) {
            $userProfile = new UserProfile();
            $userProfile->setCreated(new \DateTime());
            $userProfile->setUser($this);
            $this->setProfile($userProfile);
        }

        // Set display name
        $names = explode(' ', $displayName);
        if (count($names) > 0) {
            $userProfile->setForename($names[0]);
            if (count($names) > 1) {
                unset($names[0]);
                $userProfile->setSurname(implode(' ', $names));
            }
            $userProfile->setLastModified(new \DateTime());
        }

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        // Create password
        $userPassword = new UserPassword();
        $userPassword->setCreated(new \DateTime());
        $userPassword->setPassword($password);
        $userPassword->setUser($this);
        $this->addPassword($userPassword);

        return $this;
    }

    /**
     * Set id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

}

