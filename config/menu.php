<?php

return [
    [
        'label'  => 'الرئيسية',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-home fa-lg menu-icon"></i>',
        'url'    => '/admin/dashboard',
        // 'badge'  => 1,
        // 'badge-color'  => 'success',
    ],
    [
        'label'  => 'الكشف',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-stethoscope fa-lg menu-icon"></i>',
        'url'    => '/admin/examinations',
    ],
    [
        'label'  => 'التقارير',
        'type'   => 'link',
        'icon'   => '<i class="fas fa-chart-bar me-2"></i>',
        'url'    => '/admin/reports',
    ],
    [
        'label'  => 'الزيارات',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-calendar-check fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/visits'],
            ['label' => 'إضافة جديد', 'url' => '/admin/visits/create'],
        ],
    ],
    [
        'label'  => 'المرضي',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-user-injured fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/patients'],
            ['label' => 'إضافة جديد', 'url' => '/admin/patients/create'],
        ],
    ],
    [
        'label'  => 'الخدمات الطبية',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-notes-medical fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/services'],
            ['label' => 'إضافة جديد', 'url' => '/admin/services/create'],
        ],
    ],
    [
        'label'  => 'الأدوية',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-pills fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/drugs'],
            ['label' => 'إضافة جديد', 'url' => '/admin/drugs/create'],
        ],
    ],
    [
        'label'  => 'المستخدمين',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-users fa-lg menu-icon"></i>',
        'children' => [
            ['label' => 'عرض الكل', 'url' => '/admin/users'],
            ['label' => 'إضافة جديد', 'url' => '/admin/users/create'],
        ],
    ],
    [
        'label'  => 'الأدوار والصلاحيات',
        'type'   => 'dropdown',
        'icon'   => '<i class="fas fa-user-shield fa-lg menu-icon"></i>',
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
        'icon'   => '<i class="fas fa-cog fa-lg menu-icon"></i>',
        'url'    => '/admin/settings',
    ],
];
