<?php

namespace InfinityUser\Form;

use ZfcBase\Form\ProvidesEventsForm;

class ResetPassword extends ProvidesEventsForm
{

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->add(array(
            'name'       => 'email',
            'options'    => array(
                'label' => 'Email Address',
            ),
            'attributes' => array(
                'type' => 'email'
            ),
        ));

        $this->add(array(
            'name'       => 'submit',
            'attributes' => array(
                'value' => 'Reset',
                'type'  => 'submit'
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }

}
