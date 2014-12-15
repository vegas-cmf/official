<?php
return array(
    'admin/contributor'  =>  array(
        'route' =>  '/admin/contributors/:action',
        'paths' =>  array(
            'module' =>  'Contributor',
            'controller' =>  'Backend\GitHub',
            'action' =>  1,
            'auth'  =>  'auth'
        )
    )
);