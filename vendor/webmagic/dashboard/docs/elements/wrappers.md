> Wrappers

The functionality is implemented using several classes described below.

Wrapper classes allow you to quickly and conveniently process both simple text sentences and complex structures.

- **addContent** - add content in div
- **attr** - add attribute to div
- **attrs** - add array attributes to div
- **addClass** - add class to div

### How to use

#### WrapperDiv

The functional is implemented using the `\Webmagic\Dashboard\Elements\WrapperDiv` class.
End result `DIV` tag is used as a container for HTML elements or text.

```php
(new WrapperDiv())
    ->attr('some', 'attr')
    ->attrs(['attr1' => 'val1', 'attr2' => 'val2'])
    ->addContent('Simple WrapperDiv')
    ->addClass('text-center border');
```

#### StringElement

The functional is implemented using the `\Webmagic\Dashboard\Elements\StringElement` class.
Wraps content in html `SPAN` tag.

```php
(new StringElement('Simple StringElement'))
    ->addClass('simple_string_element border');
```

### WrapperSpan

The functional is implemented using the `\Webmagic\Dashboard\Elements\WrapperSpan` class.  
Wraps content in html `SPAN` tag.
Different between it and `StringElement` - in `WrapperSpan` you can add **icon** thanks to the built-in function.

```php
(new WrapperSpan('Simple WrapperSpan'))
    ->addClass('simple_wrapper_span border')
    ->icon('fas fa-snowplow');
```

### Complex Example

```php
(new WrapperDiv([
    (new WrapperDiv([
        (new WrapperDiv([
            new WrapperDiv(
                (new WrapperSpan('Left'))
            ),
            (new Image())->src(asset('webmagic/dashboard/img/red_pill.png')),
            (new WrapperSpan('hand'))->addClass('d-block')
        ]))->addClass('col text-danger')->addClass('text-center'),
        (new WrapperDiv([
            new WrapperDiv(
                (new WrapperSpan('Right'))
            ),
            (new Image())->src(asset('webmagic/dashboard/img/blue_pill.png')),
            (new WrapperSpan('hand'))->addClass('d-block')
        ]))->addClass('col text-primary')->addClass('text-center'),
    ]))->addClass('row'),
    (new WrapperDiv(
        (new StringElement('You take the blue pill... the story ends, you wake up in your bed and believe whatever you want to believe. You take the red pill... you stay in Wonderland, and I show you how deep the rabbit hole goes.'))
            ->addClass('col-2 offset-5 font-italic')
    ))->addClass('row')
]))->addClass('border');
```

For a more detailed example, see `\Webmagic\Dashboard\Docs\Http\PresentationController::wrappers`  