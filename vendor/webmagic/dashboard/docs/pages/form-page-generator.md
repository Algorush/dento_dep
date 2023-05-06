# Form page generation

One way to generate a form is to use the `FormPageGenerator` class.
This demonstrates how the FormPageGenerator classes work.

```php
$img = 'https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500';    

$formPageGenerator = (new \Webmagic\Dashboard\Components\FormPageGenerator())
    ->title('Page title', 'Page sub-title')
    ->method('POST')    // default POST
    ->action('/')        // default '/'
    ->ajax(true)         // set form to send with Ajax. Default 'true'
    ->input('test_name', 'Submit with custom input', '', 'submit', false, '', [], 'btn btn-default')
    ->hiddenInput('hidden_attribute', null)
    ->textInput('name', null, 'Name', true)
    ->slugInput('slug', 'name', null, 'Slug generated automatically based on name', false, '-', 'lowercase')
    ->numberInput('number', 0, 'Number input', false, 0.01)
    ->emailInput('email', 'tesdt@email.com', 'Email', true)
    ->passwordInput('password', '123', 'Password', true)
    ->colorInput('color', '#000000', 'Select color', false)
    ->checkbox('checkbox_name', false, 'Check me')
    ->switcher('switcher_name', true, 'Switch me')
    // Regular date input
    ->dateInput('date', today(), 'Date', true)
    // Date picker JS
    ->datePickerJS('date_js', today(), 'Select date with JS', true, [], true)
    // Date range picker
    ->dateRangePicker('date_range_start', 'date_range_end', today(), today(), 'Select range of dates', true, true, true)
    // Regular time picker
    ->timeInput('time', now(), 'Time')
    // Time picker JS
    ->timePickerJS('time_js', now(), 'Select time with JS', false, [], true, true)
    // Regular date and time input
    ->dateTimeInput('date_time', now(), 'DateTime', false)
    // Date and time picker with JS
    ->dateTimePickerJS('date_time_js', now(), 'Select date and time with JS (12h-format without seconds)', false, [], false, false, true)
    // Date and time range picker
    ->dateTimeRangePicker('date_time_range_start', 'date_time_range_end', today(), today(),
        'Select range of dates and times', false, false, [], true, true, true)
    // Date range
    ->dateRange('date_range', 'Date range')
    // Regular select
    ->select('select', [1 => 'Option 1', 2 => 'Option 2'], 2, 'Select me', false)
    // Multiply select
    ->select('select', [1 => 'Option 1', 2 => 'Option 2'], 2, 'Select me twice', false, true)
    // Multiply JS select with placeholder
    ->selectJS('select', [1 => 'Option 1', 2 => 'Option 2'], '', 'Select with placeholder', false, true, ['data-placeholder' => 'Select option'])
    // Regular JS select
    ->selectJS('select', [1 => 'Option 1', 2 => 'Option 2'], 2, 'Select me with JS', false)
    // JS Select with autocomplete on back-end
    ->selectWithAutocomplete('select', route('dashboard.docs.presentation.select-autocomplete'), [1 => 'London', 5 => 'Paris'], 1, 'Search with back-end autocomplete', false, true)
    ->textarea('comment', '', 'Comment')
    ->visualEditor('content', '<p>test</p>', 'Editor', true, ['disabled' => true]) // Additional params can turn on image uploading functionality
    ->fileInput('file', request(), 'File')
    ->imageInput('testImag', $img, 'Image block', '20 Mb', '10', '234', $img, 'myImage.png')
    ->submitButtonTitle('Push me')
    // Add additional button to submit the form with additional params which will be send to backend
    ->addSubmitButton(['redirect' => url('dashboard')], 'Submit and back to dashboard')
    // Add additional link button
    ->addLinkButton(url('/'), 'Go home');

return $formPageGenerator;
```

If you need to return only form on AJAX request you DON'T NEED to use expression:

```php
if(request()->ajax()){
    return $formPageGenerator->getForm();
}
```

If you need to return the ***entire page*** during an AJAX request, you SHOULD use the **renderNative** function:

```php
if(request()->ajax()){
    return $formPageGenerator->renderNative();
}
```

### Method ajax

Let's take a closer look at the ajax method.  
`\Webmagic\Dashboard\Components\FormGenerator::ajax`  
The method takes several parameters:

```php
bool $status = true,
string $resultBlockClass = '',
string $resultReplaceBlkClass = '',
bool $successNotification = true,
bool $errorNotification = true,
bool $doNotHidePopup = false
```

`$status` - submit form synchronously or asynchronously  
`$resultBlockClass` - Response will be inserted in html block with it class.  
`$resultReplaceBlkClass` - Response will replace html block with it class.  
`$successNotification` - Is show message for success responses  
`$errorNotification` - Is show message for error responses  
`$doNotHidePopup` - Is leave open popup after submit form (if it placed in popup)