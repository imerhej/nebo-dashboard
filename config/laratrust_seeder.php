<?php

return [
    'role_structure' => [
        'superadministrator' => [
            'users' => 'c,r,u,d',
            'acl' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'administrator' => [
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'manager' => [
            'users' => 'c,r',
            'profile' => 'r,u'
        ],
        'supervisor' => [
            'users' => 'c,r',
            'profile' => 'r,u'
        ],
        'installer' => [
            'profile' => 'r,u'
        ],
        'employee' => [
            'profile' => 'r,u'
        ],
        'client' => [
            'profile' => 'r,u'
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
