<?php

namespace InfinityUser\Form;

use Zend\InputFilter\InputFilter;

class ResetPasswordFilter extends InputFilter
{

    public function __construct()
    {
        $this->add(array(
            'name'       => 'email',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
            ),
        ));
    }

}
