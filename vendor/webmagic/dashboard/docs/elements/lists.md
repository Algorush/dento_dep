> Lists

The functionality is implemented using several classes described below.

The functionality allows you to create lists based on an array (key / value)

General methods

- **addData** - add content to list

Methods for DescriptionList

- **bool isHorizontal** - false - without alignment. true - content alignment
- **bool set_headers_left_align** - false - center content alignment. true - heading left alignment.

### How to use

### DataList

The functional is implemented using the `\Webmagic\Dashboard\Elements\Lists\DataList` class.

```php
$dataList = new DataList();
$dataList->addData([
    'First name' => 'John',
    'Last name' => 'Doe',
    'Age' => '20',
]);
```

### DescriptionList

The functional is implemented using the `\Webmagic\Dashboard\Elements\Links\DescriptionList` class.

#### Method 1

```php
new DescriptionList([
    'First name' => 'John',
    'Last name' => 'Doe',
    'Age' => '20',
]);
```

#### Method 2

You can make it 'horizontal' view.

```php
new DescriptionList([
    'First name' => 'John',
    'Last name' => 'Doe',
    'Age' => '20',
])->isHorizontal(true);
```

#### Method 3

Make left alignment headers.

```php
new DescriptionList([
    'First name' => 'John',
    'Last name' => 'Doe',
    'Age' => '20',
])
    ->isHorizontal(true)
    ->setHeadersLeftAlign(true);
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::lists`