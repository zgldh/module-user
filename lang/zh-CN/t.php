<?php

return [
    'title'  => "用户管理",
    'models' => [
        'user'       => [
            'title'  => '用户列表',
            'fields' => [
                'name'          => '名字',
                'email'         => '电子邮箱',
                'password'      => '密码',
                'gender'        => '性别',
                'mobile'        => '电话',
                'is_active'     => '是否激活',
                'last_login_at' => '最后登录时间',
                'login_times'   => '登录次数',
                'avatar_id'     => '头像ID',
                'avatar'        => '头像',
                'roles'         => '角色',
                'permissions'   => '权限',
            ]
        ],
        'role'       => [
            'title'  => '用户角色',
            'fields' => [
                'name'        => '英文名',
                'label'       => '中文名',
                'permissions' => '权限',
            ]
        ],
        'permission' => [
            'title'  => '用户权限',
            'fields' => [
                'name'  => '英文名',
                'label' => '中文名',
            ]
        ],
    ],
    'terms'  => [
        'leave_field_blank_if_dont_want_change_password' => '不想修改密码则留空'
    ]
];
