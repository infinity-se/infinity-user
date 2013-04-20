<?php

namespace InfinityUser\Controller;

use Zend\Form\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;
use ZfcUser\Service\User as UserService;
use ZfcUser\Options\UserControllerOptionsInterface;

class UserController extends AbstractActionController
{

    const ROUTE_RESETPASSWD = 'infinityuser/resetpassword';
    const CONTROLLER_NAME   = 'infinityuser';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var Form
     */
    protected $resetPasswordForm;

    /**
     * @var UserControllerOptionsInterface
     */
    protected $options;

    /**
     * User page
     */
    public function indexAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute(static::ROUTE_LOGIN);
        }
        return new ViewModel();
    }

    /**
     * Reset the users password
     */
    public function resetPasswordAction()
    {
        // If the user is logged in, we can't reset password
        if ($this->zfcUserAuthentication()->hasIdentity()) {
            // Redirect to the login redirect route
            return $this->redirect()->toRoute($this->getOptions()->getLoginRedirectRoute());
        }

        $form = $this->getResetPasswordForm();
        $prg  = $this->prg(static::ROUTE_RESETPASSWD);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'resetPasswordForm' => $form,
            );
        }

        $form->setData($prg);

        if (!$form->isValid()) {
            return array(
                'resetPasswordForm' => $form,
            );
        }

        if (!$this->getUserService()->resetPassword($form->getData())) {
            return array(
                'resetPasswordForm' => $form,
            );
        }

        $this->flashMessenger()->setNamespace('reset-password')->addMessage(true);
        return $this->redirect()->toRoute(static::ROUTE_RESETPASSWD);
    }

    /**
     * Getters/setters for DI stuff
     */
    public function getUserService()
    {
        if (null === $this->userService) {
            $this->userService = $this->getServiceLocator()->get('infinityuser_user_service');
        }
        return $this->userService;
    }

    public function setUserService(UserService $userService)
    {
        $this->userService = $userService;
        return $this;
    }

    public function getResetPasswordForm()
    {
        if (null === $this->resetPasswordForm) {
            $this->setResetPasswordForm($this->getServiceLocator()->get('infinityuser_reset_password_form'));
        }
        return $this->resetPasswordForm;
    }

    public function setResetPasswordForm(Form $resetPasswordForm)
    {
        $this->resetPasswordForm = $resetPasswordForm;
        return $this;
    }

}
