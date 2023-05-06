> Breadcrumbs

The functional is implemented using the `\Webmagic\Dashboard\Elements\Breadcrumbs\Breadcrumbs` class

On websites that have a lot of pages, breadcrumb navigation can greatly enhance the way users find their way around. In
terms of usability, breadcrumbs reduce the number of actions a website visitor needs to take in order to get to a
higher-level page, and they improve the find ability of website sections and pages.

Class `\Webmagic\Dashboard\Elements\Breadcrumbs\Breadcrumbs` defined as a singleton. You can get it and modify it
anywhere in the app.
Basic breadcrumbs are generating automatically based on `MainMenu` component during
in `DashboardServiceProvider::prepareBreadcrumbs()` function.

- **add** - method adds a new item, takes three parameters (link, title, icon)
- **addItem** - method adds new item, takes BreadcrumbsItem
- **clear** - method clears all items from breadcrumbs
- **updateItems** - method for completely replacing all items with the passed ones

### How to use

#### Method 1

Let's add additional active element to the end.

```php
app(Breadcrumbs::class)->add(          
    $link = '/',
    $text = 'index',
    $icon = 'fa-tachometer-alt'
);
```

#### Method 2

You can add as many elements as you need. Also, you can update all breadcrumbs by using.
For doing this you need to prepare `\Webmagic\Dashboard\Elements\Breadcrumbs\BreadcrumbsItem` for every element.

```php
$item1 = new \Webmagic\Dashboard\Elements\Breadcrumbs\BreadcrumbsItem('/', 'Index', 'fa-tachometer-alt');
$item2 = new \Webmagic\Dashboard\Elements\Breadcrumbs\BreadcrumbsItem('/', 'Second element', 'fa-tachometer-alt');
        
app(Breadcrumbs::class)->updateItems($item1, $item2);
```

#### Method 3

You can also clear all breadcrumbs items by using `clear()` function

```php
app(Breadcrumbs::class)->clear();
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::breadcrumbs`