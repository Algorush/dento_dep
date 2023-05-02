<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Dashboard title
     |--------------------------------------------------------------------------
     */
    'title'             => 'In-Align',

    /*
     |--------------------------------------------------------------------------
     | Dashboard logo configuration
     |--------------------------------------------------------------------------
     */
    'logo_settings'     => [
        'link'          => '/dashboard',
        'part_one'      => 'Web',
        'part_two'      => 'Magic',
        'part_one_mini' => 'W',
        'part_two_mini' => 'M',
    ],

    /*
     |--------------------------------------------------------------------------
     | Menu configuration
     |--------------------------------------------------------------------------
     */
    'menu'              => [
        [
            'text' => 'Dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'rank' => 0,
            'link' => 'dashboard',
            'active_rules' => [
                'routes_parts' => [
                ],
            ],
        ],
        [
            'text' => 'User Management',
            'icon' => 'fas fa-users',
            'rank' => 0,
            'link' => 'dashboard/sellers',
            'gates' => ['admin'],
            'active_rules' => [
                'routes_parts' => [
                    'dashboard::sellers.',
                    'dashboard::clients.',
                    'dashboard::deals.',
                ],
            ],
        ],
        [
            'text' => 'Clients',
            'icon' => 'fas fa-users',
            'rank' => 0,
            'link' => 'dashboard/clients',
            'gates' => ['seller'],
            'active_rules' => [
                'routes_parts' => [
                    'dashboard::clients.',
                ],
            ],
        ],
        [
            'text' => 'Cases',
            'icon' => 'fas fa-copy',
            'rank' => 0,
            'link' => 'dashboard/deals/all/seller',
            'gates' => ['seller'],
            'active_rules' => [
                'routes_parts' => [
                    'dashboard::deals.',
                ],
            ],
        ],
        [
            'text' => 'My Account',
            'icon' => 'fas fa-cog',
            'rank' => 0,
            'link' => 'dashboard/account',
            'active_rules' => [
                'routes_parts' => [
                    'dashboard::account',
                ],
            ],
        ],
        [
            'text' => 'Trash',
            'icon' => 'fas fa-trash',
            'rank' => 0,
            'link' => 'dashboard/trash',
            'gates' => ['admin'],
            'active_rules' => [
                'routes_parts' => [
                    'dashboard::trash.',
                ],
            ],
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | NavBar menu
     |--------------------------------------------------------------------------
     */
    'header_navigation' => [
        [
            'text' => 'Logout',
            'icon' => '',
            'link' => 'logout',
        ]
    ],

    /*
 |--------------------------------------------------------------------------
 | Default image for preview
 |--------------------------------------------------------------------------
 |
 | You can see the available dashboard components if enabled
 |
 */
    'default_image'     => '/webmagic/dashboard/img/default-image-png.png',


    /*
     |--------------------------------------------------------------------------
     | Activate dashboard presentation mode
     |--------------------------------------------------------------------------
     |
     | You can see the available dashboard components if enabled
     |
     */
    'presentation_mode' => false,
];
