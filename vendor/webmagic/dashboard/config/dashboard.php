<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Dashboard title
     |--------------------------------------------------------------------------
     */
    'title' => 'WebMagic Dashboard',

    /*
     |--------------------------------------------------------------------------
     | Dashboard logo configuration
     |--------------------------------------------------------------------------
     */
    'logo' => [
        'link' => '/dashboard',
        'icon' => '/webmagic/dashboard/img/default_logo.png',
        'prefer_image_logo' => false,
        'text_logo' => [
            'regular_text' => 'WebMagic',
            'collapsed_text' => 'WM'
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Toggle appearance of sidebar menu into top menu
     |--------------------------------------------------------------------------
     */
    'enable_top_sidebar' => false,

    /*
     |--------------------------------------------------------------------------
     | Admin panel style
     | docs url /dashboard/tech/change-admin-panel-style-description
     |--------------------------------------------------------------------------
     */

    'admin_panel_style' => [

        'show_user_panel' => true,

        'body' => [
            'small_text' => false,
            'accent_color_variants' => '',
        ],

        'nav_bar' => [
            'no_navbar_border' => false,
            'small_text' => false,
            'variants' => [
                'font_color' => 'dark',
                'theme_color' => 'white'
            ],
        ],

        'side_bar' => [
            'small_text' => false,
            'flat' => false,
            'legacy' => false,
            'compact' => false,
            'child_indent' => true,
            'collapsed' => false
        ],

        'footer' => [
            'small_text' => false,
        ],

        'aside' => [
            'auto_expand' => true,
            'variants' => [
                'theme_color' => 'dark',
                'background_color' => 'primary'
            ],
        ],

        'logo' => [
            'small_text' => false,
            'color' => 'gray-dark',
        ],
    ],

    /*
     |--------------------------------------------------------------------------
     | Menu configuration
     |--------------------------------------------------------------------------
     */
    'menu' => [],

    /*
     |--------------------------------------------------------------------------
     | Search configuration
     |--------------------------------------------------------------------------
     */
    'search' => [
        'show' => true,
        'action' => '/',
        'attr_name' => 'search_str',
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
            'class' => 'nav-item'
        ],
        [
            'text' => 'Preview site',
            'icon' => '',
            'link' => '/',
            'class' => 'nav-item',
            'target' => '_blank'
        ]
    ],
    /*
     |--------------------------------------------------------------------------
     | NavBar options
     |--------------------------------------------------------------------------
     */
    'header_navigation_options' => [

        /*
        | Language switcher options
        |-------------------------------
        | when language switcher is true
        | you need to specify the list of locales and the default locale
        */
        'language_switcher' => true,
        'available_locales' => [
            [
                'name' => 'English',
                'code' => 'en'
            ],
            [
                'name' => 'Dutch',
                'code' => 'de'
            ]
        ],
        'default_locale' => 'en',

        // Buttons options
        'show_collapse_sidebar_btn' => true,
        'show_home_btn' => true,
        'show_fullscreen_btn' => true
    ],

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbs generation
    |--------------------------------------------------------------------------
    | Control breadcrumbs automatic generation
    |
    */
    'breadcrubs' => [
        'generate_automatically' => true,
        'add_icons' => true,
        'add_home_link' => true,
        'home_link' => [
            'link' => '/dashboard',
            'text' => 'Dashboard',
            'icon' => 'fa-tachometer-alt'
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
    'default_image' => '/webmagic/dashboard/img/default-image-png.png',

    /*
     |--------------------------------------------------------------------------
     | Activate dashboard presentation mode
     |--------------------------------------------------------------------------
     |
     | You can see the available dashboard components if enabled
     |
     */
    'presentation_mode' => true,

    /*
     |--------------------------------------------------------------------------
     | Available types of notifications & their icons
     |--------------------------------------------------------------------------
     */
    'available_notification_types' => [
        'info' => [
            'icon' => 'fa-info',
            'auto_hide' => false,
            'auto_hide_delay' => 5,
        ],
        'danger' => [
            'icon' => 'fa-ban',
            'auto_hide' => false,
            'auto_hide_delay' => 5,
        ],
        'warning' => [
            'icon' => 'fa-warning',
            'auto_hide' => false,
            'auto_hide_delay' => 5,
        ],
        'success' => [
            'icon' => 'fa-check',
            'auto_hide' => true,
            'auto_hide_delay' => 5,
        ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Notifications hide settings
     |--------------------------------------------------------------------------
     */
    'notification_auto_close_enable' => true,
    'notification_auto_close_after' => 4, // seconds to close


    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | Can use middleware for sending form
    |
    */
    'middleware' => ['web'],

    /*
     |--------------------------------------------------------------------------
     | Dashboard API
     |--------------------------------------------------------------------------
     */
    'api_middleware' => ['web', 'auth'],

    /*
     |--------------------------------------------------------------------------
     | Images storage path
     |--------------------------------------------------------------------------
     | Path is related to the public storage directory /storage/app/public/...
     | It available from the front and as /storage/...
     | Public storage symlink should be generated first
     |
     */
    'images_directory' => 'dashboard/images',

    /*
     |--------------------------------------------------------------------------
     | Number of fields per column in the modal window for choose columns
     |--------------------------------------------------------------------------
     */
    'number_fields_in_column' => 10
];
