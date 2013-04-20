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

}

