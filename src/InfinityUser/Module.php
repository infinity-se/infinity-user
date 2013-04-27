<?php

namespace InfinityUser;

use InfinityUser\Authentication\Listener\Access as AccessListener;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements ConfigProviderInterface, DependencyIndicatorInterface, ServiceProviderInterface
{

    public function onBootstrap(EventInterface $event)
    {
        // Load event manager
        $eventManager = $event->getApplication()->getEventManager();

        // Protect routes
        $accessListener = new AccessListener();
        $eventManager->attachAggregate($accessListener);

        // Attach view rendering strategy
        $viewStrategy = new Mvc\View\Http\ViewRenderingStrategy();
        $eventManager->attachAggregate($viewStrategy);

        // Attach user service listener
        $userListener = new Service\Listener\User();
        $eventManager->getSharedManager()->attachAggregate($userListener);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories'                        => array(
                'zfcuser_user_mapper' => function ($serviceManager) {
                    return new Mapper\User(
                            $serviceManager->get('zfcuser_doctrine_em'), $serviceManager->get('zfcuser_module_options')
                    );
                },
                'infinityuser_reset_password_form' => function() {
                    $form = new Form\ResetPassword();
                    $form->setInputFilter(new Form\ResetPasswordFilter());
                    return $form;
                },
            ),
        );
    }

    public function getModuleDependencies()
    {
        return array('InfinityBootstrap', 'ZfcUserDoctrineORM');
    }

}
