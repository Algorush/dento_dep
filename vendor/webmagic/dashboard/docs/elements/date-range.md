> Date range

The functional is implemented using the `\Webmagic\Dashboard\Elements\Forms\Elements\DateRange` class

[Link to Admin LTE element](https://adminlte.io/themes/v3/pages/forms/advanced.html)

You can enable users to quickly and easily set the desired date range. Default select with predefined date ranges:
Today, Yesterday, This month, Previous month, This quarter, Previous quarter, This year, Previous year, Current and
previous months. It is also possible to add a custom range to the default ones, or you can set only your own date
ranges. The form returns data for a period in the "day.month.year-day.month.year" format. All dates with leading zeros.
The year is a two-digit number.

- **string $name** - name of element
- **string $labelTxt = ''** - label
- **string $dateFormat = ''** - custom format date
- **bool $required = false** - field is required
- **bool $emptyValue = true** - show and hide option with empty string
- **array $customRange = []** - array of custom date ranges that will be added to the end of the default ones.
- **array $attributes = []** - additional attributes

### How to use

#### Method 1

```php
(new FormGroup())->dateRange('date-range', 'Select date', '', false, true, [], [])
```

#### Method 2

```php
(new FormGenerator())->dateRange('date-range', 'Select date', '', false, true, [], [])
```

#### Method 3

Also, you can use class ``\Webmagic\Dashboard\Components\FormPageGenerator`` but only when you make single form for
whole page

```php
(new FormPageGenerator())->dateRange('date-range', 'Select date', '', false, true, [], [])
```

#### Method 4

Can be implemented through your own class.

```php
$dateRange = new DateRange();
$dateRange->addName('date-range');
$dateRange->addRequired(false);
$dateRange->setDateFormat('d-m-Y');
$dateRange->addEmptyLine('...');
$dateRange->clearRanges();
$dateRange->addRange('Last 1 days (except today)', Carbon::now()->subDays(1), Carbon::yesterday());
$dateRange->addRange('Last 5 days (except today)', Carbon::now()->subDays(5), Carbon::yesterday());
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\DateRangeController::example`