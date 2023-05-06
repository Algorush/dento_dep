> Main Menu

The functional is implemented using the `\Webmagic\Dashboard\Elements\Menus\MainMenu\MainMenu` class.
Menu items you can use `\Webmagic\Dashboard\Elements\Menus\MainMenu\Item` class.

`item` - array of attributes for item

- **string text**  - title of the link in the menu
- **string icon** - icon you can use any icon form available in AdminLTE
  fonts https://adminlte.io/themes/AdminLTE/pages/UI/icons.html
- **number rank** - parameter need for sort show menu (priority which will be first)
- **string link** - link where will be direct
- **array gates** - array names of your registered gates and if will be at least one true this item will be
  show in other case no. Also, it works for child elements (https://laravel.com/docs/9.x/authorization#gates)
- **array subitems** - array of subitems. Depth of sub items are not limited
- **array active_rules** - array of rules when item/subitem will be active

`active_rules` - array conditions when item will set as active it can include the next :

- **routes_parts** - will be look for matches with current route NAME with and values in routes_parts array. Values can
  be any. Can be part of route or name of group doesn't matter.
- **routes** - will be compare current route NAME with values in array routes. Values can be only NAMES of route.
- **urls** - will be compare current route with values in urls. Values can be only PATH without domain like - '
  dashboard/products'

`search` - array of attributes to search in the menu

- **bool show** - show/hide search in menu
- **string action** - route by which the search request will be processed
- **string attr_name = search_str** - variable name in the query

If you want to translate the elements of the main menu, then you should create a file ``resources/lang/{{locale}}.json``
in which to describe the translation from the original language to the target one.
([Laravel Docs](https://laravel.com/docs/9.x/localization#using-translation-strings-as-keys)).

### How to use

#### Method 1

You can set up MainMenu just pass an array with next structure.

```php
$menuItems = [
            [
                'text' => 'Level 1',
                'icon' => 'fa-circle',
                'link' => url('dashboard'),
                'gates' => ['admin'],
                'active_rules' => [
                    'urls' => [
                        'dashboard'
                    ],
                ]
            ],
            [
                'text' => 'level 2',
                'icon' => 'fa-circle',
                'link' => url('/'),
                'subitems' => [
                    [
                        'text' => 'level 3',
                        'icon' => 'far fa-circle',
                        'link' => url('dashboard/some'),
                        'rank' => 800,
                        'active_rules' => [
                            'urls' => [
                                'dashboard/some'
                            ],
                            'url_reg_exps' => [
                                'dashboard\/some\/.*\/edit'
                            ]
                        ],
                    ],
                    [
                        'text' => 'level 3 second time',
                        'icon' => 'far fa-circle',
                        'link' => url('dashboard/test2'),
                        'rank' => 900,
                        'active_rules' => [
                            'routes' => [
                                'tech::test',
                            ],
                        ]
                    ]
                ]
            ],
            [
                'text' => 'Level 1(second)',
                'icon' => 'fa-book',
                'link' => url('dashboard/test'),
                'rank' => 200,
                'active_rules' => [
                    'routes_parts' => [
                        'tech::',
                        'another::'
                    ],
                ]
            ]
        ];
        
$mainMenu = new \Webmagic\Dashboard\Elements\Menus\MainMenu\MainMenu($menuItems);
```

#### Method 2

Main Menu through methods

```php
// create Item
$item = new \Webmagic\Dashboard\Elements\Menus\MainMenu\Item([
    'text' => 'Item',
    'icon' => 'fa-circle',
    'link' => url('dashboard'),
    'gates' => ['admin'],
    'active_rules' => [
        'urls' => [
            'dashboard'
        ],
    ]
]);

// add rules for Item
$item->addRules([
    'routes_parts' => [
        'dashboard::'
    ],
    'routes' => [
        'filter-page'
    ],
    'urls' => [
        'dashboard/test'
    ],
    'url_reg_exps' => [
        'dashboard\/some\/.*\/edit'
    ]
]);

// create Item tree
$menuTree = new \Webmagic\Dashboard\Elements\Menus\MainMenu\Item([
    'text' => 'Tree item',
    'icon' => 'fa-book',
    'link' => url('/')
]);

//set Items as sub item
$menuTree->addSubItem($item);
$menuTree->addSubItem($item);

//set item as active
$menuTree->setActive();

$mainMenu = new MainMenu();
// add Items
$mainMenu->addMenuItems($menuTree);
// add one Item
$mainMenu->addItem($item);
// Search
$mainMenu->showSearch(true, url('dashboard/tech/main-menu'), 'search_str');
```

#### Search

Also you can easily add a search in menu

![tech.menu-search.png](/webmagic/dashboard/img/tech.menu-search.png)

and configure its parameters in `app/config/webmagic/dashboard/dashboard.php`

 ```php
    'search' => [
        'show' => true, 
        'action' => '/',
        'attr_name' => 'search_str',
    ]
```

#### Headers for menu

You can add header element for main menu `to top level`.  
It will not be a link, just semantic separator.

To make it, add to menu config array with `header` key:

```php
    ...
            'urls' => [
                'dashboard/tech/tables/manual-sorting',
                'dashboard/tech/tables/manual-sorting-example',
            ],
        ],
    ],
    [
        'header' => 'Header title'
    ]
    [
        'link'         => 'dashboard/tech/table-page-description',
        'text'         => 'Table Page',
        'icon'         => 'far fa-circle',
        'active_rules' => [
            'urls' => [
    ...
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::mainMenu`