<?php

namespace InfinityUser\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class UserNavigationFactory extends DefaultNavigationFactory
{

    protected function getName()
    {
        return 'user';
    }

}

