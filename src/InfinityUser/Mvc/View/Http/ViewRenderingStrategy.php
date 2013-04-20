<?php

namespace InfinityUser\Mvc\View\Http;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventInterface;
use Zend\View\Renderer\PhpRenderer;

class ViewRenderingStrategy implements ListenerAggregateInterface
{

    /**
     * @var array
     */
    protected $_listeners = array();

    public function attach(EventManagerInterface $eventManager)
    {
        $this->_listeners[] = $eventManager->attach(
                'render', array($this, 'load'), 900
        );
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
     * Load view parameters
     *
     * @param EventInterface $event
     */
    public function load(EventInterface $event)
    {
        // Load variables
        $application    = $event->getTarget();
        $serviceManager = $application->getServiceManager();

        // Check for renderer
        if (!$serviceManager->has('ViewRenderer')) {
            return;
        }

        // Check renderer
        $renderer = $serviceManager->get('ViewRenderer');
        if (!$renderer instanceof PhpRenderer) {
            return;
        }

        // Cache base path
        $basePath = $renderer->basePath();

        // Check for identity if authentication is used
        $authService = $serviceManager->get('zfcuser_auth_service');
        if ($authService && !$authService->hasIdentity()) {

            // Setup login layout
            $renderer->layout('layout/login');

            // Add head links
            $renderer->headLink()
                    ->setStylesheet($basePath . '/css/login.css');

            // Remove head script
            $renderer->headScript()
                    ->setScript(null);

            // Add inline script
            $renderer->inlineScript()->setFile($basePath . '/js/login.js');
        }
    }

}

