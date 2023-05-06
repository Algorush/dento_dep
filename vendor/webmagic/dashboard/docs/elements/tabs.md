> Tabs

The functional is implemented using the `\Webmagic\Dashboard\Elements\Tabs\Tabs` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/UI/navbar.html)

The functionality allows you to split content into different tabs without having to reload the page when switching
between tabs. Tabs container. All tabs are added to it.

In order to display tabs, you need a container to store them.

- **addTab, tabs** - the method adds tabs to the container, which returns a new **Tab** instance
- **addClass** - the method adds a class for the tab container
- **content** - adding content to a tab
- **title** - title for the tab
- **active** - make tab active
- **parent** - method to add multiple tabs in a chain
- **getNavigation** - get instance class `Navigation` for add attributes or set a class for the tab navigation bar
- **navigation** - set navigation bar for tabs

### How to use

#### Method 1

```php
$tabs = (new Tabs())
    ->addTab()->title('Image')->content($image)->active()
    ->parent()->addTab()->title('Lorem Ipsum')->content('Lorem Ipsum')
    ->parent();
```

#### Method 2

**Navigation** Pane with a list of tabs  
The functional is implemented using the `\Webmagic\Dashboard\Elements\Tabs\Navigation` class  
If you need to add attributes or set a class for the tab Navigation bar, then it can be obtained through the **Tabs**
instance.
If the Navigation is implemented before Tabs, then it can be passed inside the Tabs instance

```php
$tabs = (new Tabs())
    ->addTab()->title('Tab 1')->content('Lorem Ipsum text 1')->active()
    ->parent()->addTab()->title('Tab 2')->content('Lorem Ipsum text 2')
    ->parent();

$navigation = $tabs->getNavigation()->addClass('bg-warning');
$tabs->navigation($navigation);
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::tabs`