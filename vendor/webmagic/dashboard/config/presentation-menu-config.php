<?php

return [
    [
        'text'     => 'Dashboard details',
        'icon'     => 'fa-info',
        'subitems' => [
            [
                'link'         => 'dashboard/tech/installation',
                'text'         => 'Installation',
                'icon'         => 'far fa-circle',
                'active_rules' => [
                    'urls' => [
                        'dashboard/tech/installation'
                    ],
                ],
            ],
            [
                'text'     => 'Config',
                'icon'     => 'fa-circle',
                'subitems' => [
                    [
                        'link'         => 'dashboard/tech/change-admin-panel-style-description',
                        'text'         => 'Change style',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/change-admin-panel-style-description'
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/small-notifications',
                        'text'         => 'Notifications',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/small-notifications'
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/top-menu',
                        'text'         => 'Top menu',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/top-menu',
                                'dashboard/tech/top-menu/presentation-mode'
                            ]
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/middleware',
                        'text'         => 'Middleware',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/middleware',
                        ],
                    ],
                ]
            ],
            [
                'text'     => 'Pages',
                'icon'     => 'fa-circle',
                'subitems' => [
                    [
                        'link'         => 'dashboard/tech/tiles-list-page-description',
                        'text'         => 'Tiles list page',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/tiles-list-page',
                                'dashboard/tech/tiles-list-page-description',
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/page-generator',
                        'text'         => 'Form Page Generator',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/page-generator',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/form-group',
                        'text'         => 'Form Group',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/form-group',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/login-page',
                        'text'         => 'Login Page',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/login-page',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/blank-page',
                        'text'         => 'Blank Page',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/blank-page',
                        ],
                    ],
                ],
            ],
            [
                'text'     => 'Table',
                'icon'     => 'fa-circle',
                'subitems' => [
                    [
                        'link'         => 'dashboard/tech/tables/manual-sorting',
                        'text'         => 'Manual sorting',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/tables/manual-sorting',
                                'dashboard/tech/tables/manual-sorting-example',
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/tables/sorting',
                        'text'         => 'Sorting',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/tables/sorting',
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/tables/choose-columns',
                        'text'         => 'Choose columns',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/tables/choose-columns',
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/table-page-description',
                        'text'         => 'Table Page',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/table-page',
                                'dashboard/tech/table-page-description',
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/tables/pagination',
                        'text'         => 'Pagination',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/tables/pagination',
                                'dashboard/tech/tables/pagination/base-using',
                                'dashboard/tech/tables/pagination/base-using-with-dropdown',
                                'dashboard/tech/tables/pagination/with-custom-per-page',
                                'dashboard/tech/tables/pagination/with-two-tables',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'text'     => 'Elements',
                'icon'     => 'fa-circle',
                'subitems' => [
                    [
                        'text'     => 'Inputs',
                        'icon'     => 'fa-circle',
                        'subitems' => [
                            [
                                'link'         => 'dashboard/tech/password-input',
                                'text'         => 'passwordInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/password-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/text-input',
                                'text'         => 'textInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/text-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/slug-input',
                                'text'         => 'slugInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/slug-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/email-input',
                                'text'         => 'emailInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/email-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/number-input',
                                'text'         => 'numberInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/number-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/input',
                                'text'         => 'input',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/hidden-input',
                                'text'         => 'hiddenInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/hidden-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/file-input',
                                'text'         => 'fileInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/file-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/color-input',
                                'text'         => 'colorInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/color-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/textarea',
                                'text'         => 'textarea',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/textarea',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/checkbox',
                                'text'         => 'checkbox',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/checkbox',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/switcher',
                                'text'         => 'switcher',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/switcher',
                                ],
                            ],
                        ],
                    ],
                    [
                        'text'     => 'Date & Time',
                        'icon'     => 'fa-circle',
                        'subitems' => [
                            [
                                'link'         => 'dashboard/tech/date-input',
                                'text'         => 'dateInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/date-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/time-input',
                                'text'         => 'timeInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/time-input',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/date-time-input',
                                'text'         => 'dateTimeInput',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/date-time-input',
                                ],
                            ],
                            [
                                'text'     => 'DateTimePicker',
                                'icon'     => 'fa-circle',
                                'subitems' => [
                                    [
                                        'link'         => 'dashboard/tech/date-time-picker',
                                        'text'         => 'DateTimePicker',
                                        'icon'         => 'far fa-circle',
                                        'active_rules' => [
                                            'urls' => 'dashboard/tech/date-time-picker',
                                        ],
                                    ],
                                    [
                                        'link'         => 'dashboard/tech/time-picker-js',
                                        'text'         => 'timePickerJs',
                                        'icon'         => 'far fa-circle',
                                        'active_rules' => [
                                            'urls' => 'dashboard/tech/time-picker-js',
                                        ],
                                    ],
                                    [
                                        'link'         => 'dashboard/tech/date-time-picker-js',
                                        'text'         => 'dateTimePickerJS',
                                        'icon'         => 'far fa-circle',
                                        'active_rules' => [
                                            'urls' => 'dashboard/tech/date-time-picker-js',
                                        ],
                                    ]
                                ]
                            ],
                            [
                                'link'         => 'dashboard/tech/date-range',
                                'text'         => 'Date range',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/date-range',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/date-range-js',
                                'text'         => 'Date range js',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/date-range-js',
                                ],
                            ],
                        ],
                    ],
                    [
                        'text'     => 'Selects',
                        'icon'     => 'fa-circle',
                        'subitems' => [
                            [
                                'link'         => 'dashboard/tech/select',
                                'text'         => 'select',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/select',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/select-js',
                                'text'         => 'selectJs',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/select-js',
                                ],
                            ],
                            [
                                'link'         => 'dashboard/tech/select-with-autocomplete',
                                'text'         => 'selectWithAutocomplete',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/select-with-autocomplete',
                                ],
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/main-menu',
                        'text'         => 'Main menu',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/main-menu',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/photo-uploading',
                        'text'         => 'Photo uploading',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/photo-uploading',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/images',
                        'text'         => 'Images',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/images',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/visual-editor',
                        'text'         => 'Visual Editor',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/visual-editor',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/breadcrumbs',
                        'text'         => 'Breadcrumbs',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/breadcrumbs',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/notifications-description',
                        'text'         => 'Notifications',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => [
                                'dashboard/tech/notifications-description',
                                'dashboard/tech/notifications',
                            ],
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/box',
                        'text'         => 'Box',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/box',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/flexible-date-time-picker',
                        'text'         => 'Flexible DateTime picker',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/flexible-date-time-picker',
                        ],
                    ],
                    [
                        'text'     => 'Multifields',
                        'icon'     => 'fa-circle',
                        'subitems' => [
                            [
                                'link'         => 'dashboard/tech/multifields-simple',
                                'text'         => 'Multifields simple',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/multifields-simple',
                                ]
                            ],
                            [
                                'link'         => 'dashboard/tech/multifields-complex',
                                'text'         => 'Multifields complex',
                                'icon'         => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/multifields-complex',
                                ]
                            ]
                        ]
                    ],
                    [
                        'link'         => 'dashboard/tech/lists',
                        'text'         => 'Lists',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/lists',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/image',
                        'text'         => 'Image',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/image',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/badge',
                        'text'         => 'Badge',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/badge',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/wrappers',
                        'text'         => 'Wrappers',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/wrappers',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/tabs',
                        'text'         => 'Tabs',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/tabs',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/grid',
                        'text'         => 'Grid',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/grid',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/links',
                        'text'         => 'Links',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/links',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/progressbar',
                        'text'         => 'Progress bar',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/progressbar',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/graphic',
                        'text'         => 'Graphic',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/graphic',
                        ],
                    ],
                    [
                        'text' => 'Widgets',
                        'icon' => 'fa-circle',
                        'subitems' => [
                            [
                                'link' => 'dashboard/tech/simple-widget',
                                'text' => 'Simple widget',
                                'icon' => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/simple-widget',
                                ],
                            ],
                            [
                                'link' => 'dashboard/tech/progress-widget',
                                'text' => 'Progress widget',
                                'icon' => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/progress-widget',
                                ],
                            ],
                            [
                                'link' => 'dashboard/tech/box-widget',
                                'text' => 'Box widget',
                                'icon' => 'far fa-circle',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/box-widget',
                                ],
                            ],
                        ]
                    ],
                ]
            ],
            [
                'text'     => 'JS actions',
                'icon'     => 'fa-circle',
                'subitems' =>
                    [
                        [
                            'text'         => 'Fast JS Actions',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions',
                            ],
                        ],
                        [
                            'text'         => 'Mask',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/mask-description',
                            'active_rules' => [
                                'urls' => [
                                    'dashboard/tech/mask',
                                    'dashboard/tech/mask-description',
                                ],
                            ],
                        ],
                        [
                            'text'         => 'Confirmation popup',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/confirmation-popup',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/confirmation-popup',
                            ],
                        ],
                        [
                            'text'         => 'Tooltips',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/tooltips',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/tooltips',
                            ],
                        ],
                        [
                            'text'         => 'Content copy',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/content-copy-to-clipboard',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/content-copy-to-clipboard',
                            ],
                        ],
                        [
                            'text'         => 'Hide/Show block',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/hide-show-on-click',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/hide-show-on-click',
                            ],
                        ],
                        [
                            'text'         => 'Controlled Checkboxes',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/controlled-checkboxes',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/controlled-checkboxes',
                            ],
                        ],
                        [
                            'text'         => 'Delete with confirmation',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/delete-with-confirmation',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/delete-with-confirmation',
                            ],
                        ],
                        [
                            'link'         => 'dashboard/tech/js-actions/auto-update',
                            'text'         => 'Auto update elements',
                            'icon'         => 'far fa-circle',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/auto-update',
                            ],
                        ],
                        [
                            'text'         => 'Activity Controller',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/activity-controller',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/activity-controller',
                            ],
                        ],
                        [
                            'text'         => 'Open in modal',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/open-in-modal',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/open-in-modal',
                            ],
                        ],
                        [
                            'text'         => 'Send request',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/send-request',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/send-request',
                            ],
                        ],
                        [
                            'text'         => 'Editable text',
                            'icon'         => 'far fa-circle',
                            'link'         => 'dashboard/tech/js-actions/editable-text',
                            'active_rules' => [
                                'urls' => 'dashboard/tech/js-actions/editable-text',
                            ],
                        ],
                    ],

            ],
            [
                'text'     => 'JS scripts',
                'icon'     => 'fa-circle',
                'subitems' => [
                    [
                        'link'         => 'dashboard/tech/js-scripts/sortable',
                        'text'         => 'Sortable',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/js-scripts/sortable',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/js-scripts/controlled-checkboxes',
                        'text'         => 'Controlled Checkboxes',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/js-scripts/controlled-checkboxes',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/js-scripts/date-range-picker',
                        'text'         => 'DateRangePicker',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/js-scripts/date-range-picker',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/js-scripts/notifications',
                        'text'         => 'Notifications',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/js-scripts/notifications',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/js-scripts/send-ajax',
                        'text'         => 'Sending Ajax',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/js-scripts/send-ajax',
                        ],
                    ],
                    [
                        'link'         => 'dashboard/tech/js-scripts/input-mask',
                        'text'         => 'Input mask',
                        'icon'         => 'far fa-circle',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/js-scripts/input-mask',
                        ],
                    ],
                    [
                        'text'         => 'File uploader',
                        'icon'         => 'far fa-circle',
                        'link'         => 'dashboard/tech/js-scripts/file-uploader',
                        'active_rules' => [
                            'urls' => 'dashboard/tech/js-scripts/file-uploader',
                        ],
                    ],
                    [
                        'text'         => 'Dynamic MultiFields',
                        'icon'         => 'far fa-circle',
                        'subitems' => [
                            [
                                'text'         => 'Simple',
                                'icon'         => 'far fa-circle',
                                'link'         => 'dashboard/tech/js-scripts/dynamic-multifields-simple',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/js-scripts/dynamic-multifields-simple',
                                ],
                            ],
                            [
                                'text'         => 'Complex',
                                'icon'         => 'far fa-circle',
                                'link'         => 'dashboard/tech/js-scripts/dynamic-multifields-complex',
                                'active_rules' => [
                                    'urls' => 'dashboard/tech/js-scripts/dynamic-multifields-complex',
                                ],
                            ],
                        ]
                    ],
                ]
            ]
        ],
    ],
];
