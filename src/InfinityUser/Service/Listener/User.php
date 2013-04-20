<?php

namespace InfinityUser\Service\Listener;

use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\EventManager\EventInterface;

class User implements SharedListenerAggregateInterface
{

    /**
     * @var array
     */
    protected $_listeners = array();

    public function attachShared(SharedEventManagerInterface $sharedEventManager)
    {
        $this->_listeners[] = $sharedEventManager->attach(
                'ZfcUser\Service\User', 'authenticate', array($this, 'authenticate'), 1000
        );
        $this->_listeners[] = $sharedEventManager->attach(
                'ZfcUser\Service\User', 'register', array($this, 'register'), 1000
        );
    }

    public function detachShared(SharedEventManagerInterface $sharedEventManager)
    {
        foreach ($this->_listeners as $index => $listener) {
            if ($sharedEventManager->detach('ZfcUser\Service\User', $listener)) {
                unset($this->_listeners[$index]);
            }
        }
    }

    /**
     * Authenticate user
     *
     * @param EventInterface $event
     */
    public function authenticate(EventInterface $event)
    {

    }

    /**
     * Register user
     *
     * @param EventInterface $event
     */
    public function register(EventInterface $event)
    {
        // Load user entity
        $user = $event->getParam('user');

        // Set proper password
        $userPasswords = $user->getPasswords();
        $userPassword  = $userPasswords[0];
        $user->removePassword($userPassword);

        // Persist objects
        $userMapper = $event->getTarget()->getUserMapper();
        $userMapper->persistOnly($user);
        $userMapper->persistOnly($userPasswords[1]);
        $userMapper->persistOnly($user->getPrimaryEmail());
        $userMapper->persistOnly($user->getProfile());
    }

}

