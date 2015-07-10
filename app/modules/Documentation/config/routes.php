<?php
return [

    'documentation' => [
        'route' => '/documentation/:params',
        'paths' => [
            'module'    =>  'Documentation',
            'controller' => 'Documentation',
            'action' => 'viewer',
            'params' => 1,
            'auth' => false
        ]
    ],
    
    'documentation/pdf' => [
        'route' => '/documentation/pdf/:params',
        'paths' => [
            'module'    =>  'Documentation',
            'controller' => 'Documentation',
            'action' => 'pdf',
            'params' => 1,
            'auth' => false
        ]
    ],
    
    'admin/documentation/version' => [
        'route' => '/admin/documentation/versions/:action/:params',
        'paths' => [
            'module'    =>  'Documentation',
            'controller' => 'Backend\Version',
            'action' => 1,
            'params' => 2,
            'auth' => 'auth'
        ]
    ],
    
    'admin/documentation/category' => [
        'route' => '/admin/documentation/categories/:action/:params',
        'paths' => [
            'module'    =>  'Documentation',
            'controller' => 'Backend\Category',
            'action' => 1,
            'params' => 2,
            'auth' => 'auth'
        ]
    ],
    
    'admin/documentation/article' => [
        'route' => '/admin/documentation/articles/:action/:params',
        'paths' => [
            'module'    =>  'Documentation',
            'controller' => 'Backend\Article',
            'action' => 1,
            'params' => 2,
            'auth' => 'auth'
        ]
    ]
    
];