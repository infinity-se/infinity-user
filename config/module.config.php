<?php

return array(
    'zfcuser' => array(
        'user_entity_class' => 'InfinityUser\Entity\User',
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'css/login.css' => array(
                    'less/bootstrap.less',
                    'css/bootstrap-login.css',
                    'less/bootstrap-responsive.less',
                ),
                'js/login.js'   => array(
                    'js/jquery.js',
                    'js/bootstrap.js',
                ),
            ),
            'map'         => array(
                'css/bootstrap-login.css' => __DIR__ . '/../assets/css/bootstrap-login.css',
            ),
        ),
        'filters' => array(
            'css/login.css' => array(
                array(
                    'service' => 'SxBootstrap\Service\BootstrapFilter',
                ),
            ),
        ),
    ),
    'doctrine'      => array(
        'driver' => array(
            'infinityuser_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/InfinityUser/Entity',
                ),
            ),
            'orm_default'                    => array(
                'drivers' => array(
                    'InfinityUser\Entity' => 'infinityuser_annotation_driver'
                )
            )
        )
    ),
    'view_manager'  => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => array(
            'layout/login' => __DIR__ . '/../view/layout/login.phtml',
        ),
        'template_path_stack'      => array(
            __DIR__ . '/../view',
        ),
    ),
);
