<?php

return [
    [
        'label'  => 'الرئيسية',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-home menu-icon"></i>',
        'url'    => '/admin/dashboard',
        // 'badge'  => 1,
        // 'badge-color'  => 'success',
    ],
    [
        'label'  => 'المرضي',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-user-injured menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/patients'],
            ['label' => 'إضافة جديد', 'url' => '/admin/patients/create'],
        ],
    ],
    [
        'label'  => 'المستخدمين',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-users menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/users'],
            ['label' => 'إضافة جديد', 'url' => '/admin/users/create'],
        ],
    ],
    [
        'label'  => 'الأدوار والصلاحيات',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-user-shield menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الأدوار', 'url' => '/admin/roles'],
            ['label' => 'إضافة دور جديد', 'url' => '/admin/roles/create'],
            ['label' => 'عرض الصلاحيات', 'url' => '/admin/permissions'],
            ['label' => 'إضافة صلاحية جديدة', 'url' => '/admin/permissions/create'],
        ],
    ],
    [
        'label'  => 'الإعدادات',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-cog menu-icon"></i>',
        'url'    => '/admin/settings',
    ],
];
