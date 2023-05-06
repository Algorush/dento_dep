# Blank page

> The purpose of this functionality is to demonstrate the elements of the package without unnecessary elements, such as menus.

## Create
You can create the default empty page in simple way
```php
$page = new \Webmagic\Dashboard\Pages\BlankPage();
```
This code will create empty page with dashboard styles, but unlike \Webmagic\Dashboard\Pages\BasePage it doesn't have left menu, top menu, and footer.
Available area is only *content*.

## Content area
The most important and usefully part of the page is content area. You can put inside any content in string format or any objects which implements the \Webmagic\Dashboard\Core\Renderable

Content area is default area for the Basic Page. So you can put content inside with all the next ways
```php
$page = new \Webmagic\Dashboard\Pages\BlankPage('Content when create');
$page->title('Blank Page Title');
$page->content('Update the content');
$page->addContent('Add content content to current');
$page->content(new \Webmagic\Dashboard\Elements\Boxes\Box()); // add renderable element as content
```

For a more detailed example, see ``\Webmagic\Dashboard\Docs\Http\PresentationController::blankPageDescriptionExample``  