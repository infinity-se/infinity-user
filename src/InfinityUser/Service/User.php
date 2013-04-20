<?php

namespace InfinityUser\Service;

use Zend\Authentication\AuthenticationService;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcBase\EventManager\EventProvider;

class User extends EventProvider implements ServiceManagerAwareInterface
{

    /**
     * @var UserMapperInterface
     */
    protected $userMapper;

    /**
     * @var Form
     */
    protected $resetPasswordForm;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Reset the current users password
     *
     * @param array $data
     * @return boolean
     */
    public function resetPassword(array $data)
    {
        // Load user from email
        $emailAddress = $data['email'];
        $currentUser  = $this->getUserMapper()->findByEmail($emailAddress);

        if (!$currentUser) {
            $this->addMessage('Email sent.');
            return false;
        }

//        $pass = $bcrypt->create($newPass);
//        $currentUser->setPassword($pass);

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $currentUser));
        $this->getUserMapper()->update($currentUser);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('user' => $currentUser));

        return true;
    }

    public function resetPassword2()
    {
        // Validate form
        $form = $this->_form('ResetPassword');
        if (!$form->isValid()) {
            return false;
        }

        // Load user from email
        $data = $form->getData();
        $user = $this->getUserMapper()->findByEmailAddress($data['email']);

        // Create new password
        $randomString = Rand::getString(16);
        $userPassword = $this->_createNewUserPassword($user, $randomString);

        // Send email to user
        $message = $this->_email(
                $data['email'], 'Your New Password', 'new-password', array('password' => $randomString)
        );
        if (!$message) {
            $this->_addMessage('Unable to send new password email.', 'error');
            return false;
        }

        // Insert password
        $this->getEntityManager()->persist($userPassword);

        // Save
        return $this->_save(
                        'Your password has been reset.', 'Unable to save new password.'
        );
    }

    /**
     * getUserMapper
     *
     * @return UserMapperInterface
     */
    public function getUserMapper()
    {
        if (null === $this->userMapper) {
            $this->userMapper = $this->getServiceManager()->get('infinityuser_user_mapper');
        }
        return $this->userMapper;
    }

    /**
     * setUserMapper
     *
     * @param UserMapperInterface $userMapper
     * @return User
     */
    public function setUserMapper(UserMapperInterface $userMapper)
    {
        $this->userMapper = $userMapper;
        return $this;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $serviceManager
     * @return User
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    /**
     * Add a message to the flashMessenger
     *
     * @param string|array $message
     * @param string $namespace
     */
    protected function addMessage($message, $namespace = 'default')
    {
        // Load flashMessenger
        if (!isset($this->_flashMessenger)) {
            $this->_flashMessenger = $this->getServiceManager()
                    ->get('ControllerPluginManager')
                    ->get('flashMessenger');
        }

        // Set current namespace
        $this->_flashMessenger->setNamespace($namespace);

        // Add messages
        $message = (array) $message;
        foreach ($message as $value) {
            $this->_flashMessenger->addMessage($value);
        }
    }

}
