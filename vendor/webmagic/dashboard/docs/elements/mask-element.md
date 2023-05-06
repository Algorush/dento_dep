## Create Input element with mask

You have two ways to create elements with mask:
```php
Webmagic\Dashboard\Dashboard $dashboard;

$element = new Webmagic\Dashboard\Elements\Forms\Elements\Input();
$element->js()->mask()->number();
$dashboard->addContent($element);
```

Or

```php
Webmagic\Dashboard\Dashboard $dashboard;

$element = new Webmagic\Dashboard\Elements\Forms\Elements\Input();
$elementWithMask = (new Webmagic\Dashboard\JsActionsMask($element))->number();
$dashboard->addContent($elementWithMask);
```

Instead of <b>number</b>, you can use one of the following values:<br>
<b>number</b><br>
<b>email</b><br>
<b>number2DecPlaces</b> - Number with two decimal places<br>
<b>dateEuro24</b> - European date and time 24h format<br>
<b>dateUSA12</b> - Date USA and time 12h format<br>
<b>time12h</b> - Time 12h format<br>
<b>time24h</b> - Time 24h format<br>
<b>dateUSA</b> - USA date format<br>
<b>dateEuro</b> - European date format