<?php

namespace InfinityUser\Authentication\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventInterface;

class Access implements ListenerAggregateInterface
{

    /**
     * @var array
     */
    protected $_listeners = array();

    public function attach(EventManagerInterface $eventManager)
    {
        $this->_listeners[] = $eventManager
                ->attach('route', array($this, 'check'), -100);
    }

    public function detach(EventManagerInterface $eventManager)
    {
        foreach ($this->_listeners as $index => $listener) {
            if ($eventManager->detach($listener)) {
                unset($this->_listeners[$index]);
            }
        }
    }

    /**
     * Check for XmlHttpRequest
     *
     * @param EventInterface $event
     * @return Response|void
     */
    public function check(EventInterface $event)
    {
        // Check route
        $routeMatch = $event->getRouteMatch();
        if (!$routeMatch) {
            // Not been routed
            return;
        }

        // Set variables
        $controllerName = $routeMatch->getParam('controller', false);

        // Check controller
        $controllers = array('zfcuser', 'infinityuser');
        if (in_array($controllerName, $controllers)) {

            // Check action
            $actionName = $routeMatch->getParam('action');

            // Identity not allowed
            $noIdentity = array('login', 'register', 'resetPassword');
            if (in_array($actionName, $noIdentity)) {

                // Check identity
                $application    = $event->getApplication();
                $serviceManager = $application->getServiceManager();
                $authentication = $serviceManager->get('zfcuser_auth_service');
                if (!$authentication->hasIdentity()) {
                    return;
                }

                // Add error message
                $this->_addMessage($serviceManager, 'You are already logged in.');

                // Build url
                $url = $this->_buildUrl($event);

                return $this->_redirect($event, $url);
            }
        }

        // Check identity
        $application    = $event->getApplication();
        $serviceManager = $application->getServiceManager();
        $authentication = $serviceManager->get('zfcuser_auth_service');
        if ($authentication->hasIdentity()) {
            // Authorised
            return;
        }

        // Add error message
        $this->_addMessage($serviceManager, 'You must be logged in to proceed.');

        // Build redirect url
        $origin = $event->getRequest()->getUri()->getPath();
        $target = $this->_buildUrl($event);
        $url    = $target . '/login?redirect=' . $origin;

        return $this->_redirect($event, $url);
    }

    protected function _redirect($event, $url)
    {
        // Build redirect response
        $response = $event->getResponse();
        $response->getHeaders()->addHeaderLine('Location', $url);
        $response->setStatusCode(302);

        return $response;
    }

    protected function _addMessage($serviceManager, $message)
    {
        $pluginManager  = $serviceManager->get('ControllerPluginManager');
        $flashMessenger = $pluginManager->get('flashMessenger');
        $flashMessenger->addMessage($message);
    }

    protected function _buildUrl($event, $params = array())
    {
        $router = $event->getRouter();
        $url    = $router->assemble(
                $params, array('name' => 'zfcuser')
        );

        return $url;
    }

}

