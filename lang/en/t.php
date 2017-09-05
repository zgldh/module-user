<?php

return [
    'title'  => "User Management",
    'models' => [
        'user'       => [
            'title'  => 'Users',
            'fields' => [
                'name'          => 'Name',
                'email'         => 'Email',
                'password'      => 'Password',
                'gender'        => 'Gender',
                'mobile'        => 'Mobile',
                'is_active'     => 'Is Active',
                'last_login_at' => 'Last Login At',
                'login_times'   => 'Login Times',
                'avatar_id'     => 'Avatar ID',
                'avatar'        => 'Avatar',
                'roles'         => 'Roles',
                'permissions'   => 'Permissions',
            ]
        ],
        'role'       => [
            'title'  => 'Roles',
            'fields' => [
                'name'        => 'Name',
                'label'       => 'Label',
                'permissions' => 'Permissions',
            ]
        ],
        'permission' => [
            'title'  => 'Permissions',
            'fields' => [
                'name'  => 'Name',
                'label' => 'Label',
            ]
        ],
    ],
    'terms'  => [
        'leave_field_blank_if_dont_want_change_password' => 'Leave the field blank if you don\'t want to change password.'
    ]
];
