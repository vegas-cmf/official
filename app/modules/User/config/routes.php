<?php
return array(
    'admin/user' => array(
        'route' => '/admin/users/:action/:params',
        'paths' => array(
            'module'    =>  'User',
            'controller' => 'Backend\User',
            'action' => 1,
            'params' => 2,
            'auth' => 'auth'
        )
    )
);