<?php
return array(
    'admin/project'  =>  array(
        'route' =>  '/admin/projects/:action/:params',
        'paths' =>  array(
            'module' =>  'Project',
            'controller' =>  'Backend\Project',
            'action' =>  1,
            'params' => 2,
            'auth'  =>  'auth'
        )
    )
);