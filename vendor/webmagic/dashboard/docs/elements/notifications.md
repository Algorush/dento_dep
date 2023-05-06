> Notifications

The functional is implemented using the `\Webmagic\Dashboard\Elements\Notifications\Notification` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/UI/general.html)

Provide contextual feedback messages for typical user actions with the handful of available and flexible alert messages.
**NotificationService is a singleton! It's important!**. You can push notification to massage bag from everywhere of
your code. It will be displayed in global notification area on the page.

- **string title = 'Info'** - title for notification
- **string text = ''** - text for notification
- **bool button = true** - show and hide close button
- **string type = 'info'** - type notification (info, danger, warning, success)
- **string icon = 'fas fa-info'** - icon before title ('', 'fas fa-info', 'fas fa-ban', fa-exclamation-circle, fa-check)
- **bool addHide = false** - automatically hide notification
- **int addAutoHideDelay = 5** - delay for auto close

### How to use

#### Method 1

Or you can use element factory. Call the notification method on the element.

```php
(new Box())->addElement()->notification()
    ->title('Warning!')
    ->text('Warning notification added via the notification method on the box')
    ->button(true)
    ->type('warning')
    ->icon('fas fa-exclamation-circle')
    ->autoHide(true)
    ->autoHideDelay(3)
```

#### Method 2

Can be used in Dashboard.

```php
(new Dashboard)->page()->showWarningNotification('Warning!', 'Lorem ipsum', false, true)
```

#### Method 3

You can create a notification in default way on page.
You can set few types of notifications in quick way: warning, danger, info & success

```php
(new BasePage())->showSuccessNotification('Success!', 'Lorem ipsum', $closeButton = true, $autoHide = false, $autoHideDelay = null);
(new BasePage())->showInfoNotification('Info!', 'Lorem ipsum', $closeButton = true, $autoHide = false, $autoHideDelay = null);
(new BasePage())->showWarningNotification('Warning!', 'Lorem ipsum', $closeButton = true, $autoHide = false, $autoHideDelay = null);
(new BasePage())->showDangerNotification('Danger!', 'Lorem ipsum', $closeButton = true, $autoHide = false, $autoHideDelay = null);
```

#### Method 4

Notification via own class.

```php
(new Notification())
    ->type('danger')
    ->icon('fas fa-ban')
    ->title('Alert!')
    ->content('Danger type alert preview.')
```

#### Method 5

Use Notification Service. NotificationService is a singleton! It's important!
You can push notification to massage bag from everywhere of your code. It will be displayed in global notification area
on the page.

```php
$service = app()->make(Webmagic\Dashboard\NotificationService\NotificationService::class);
$service->addMessage('warning', 'Global note', $group = 'global');
```

In third argument you can pass prefix name for storing messages in Cache.  
When you use one of methods of \Webmagic\Dashboard\NotificationService\NotificationService:

```php
public function getAllMessages(string $group = null, bool $saveForLater = false): array
public function getFirstMessage(string $type = '*', string $group = 'global', bool $saveForLater = false): string
public function getGroup(string $group, string $type = '*', bool $saveForLater = false): array
public function getByType(string $type, string $group = 'global', bool $saveForLater = false): array
```

You can pass last argument as bool ``true`` for saving message(s) after getting. If you use default value, message will
be removed from storage.

Also, you can disable global notifications by method turnOffGlobalNotifications()

```php
$page->turnOffGlobalNotifications();
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::notificationsDescription`
