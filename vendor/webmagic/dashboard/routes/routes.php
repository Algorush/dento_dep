<?php

use Illuminate\Http\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Webmagic\Dashboard\Docs\Http\PresentationController;

Route::group([
    'prefix'     => 'dashboard/tech',
    'as'         => 'dashboard.docs.presentation.',
    'namespace'  => 'Webmagic\Dashboard\Docs\Http',
    'middleware' => config('webmagic.dashboard.dashboard.middleware'),
], function () {

    // Pages generation examples
    include 'pages-examples.php';

    // Elements generation examples
    include 'elements-examples.php';

    // Tables presentation
    include 'tables-docs.php';

    // Installation
    Route::get('installation', [
        'as'   => 'installation',
        'uses' => 'PresentationController@installation',
    ]);

    // JS script sortable description page
    Route::get('js-scripts/sortable', [
        'as'   => 'js-scripts.sortable',
        'uses' => 'JSScriptsPresentationController@sortable',
    ]);

    // JS script controlled checkboxes description page
    Route::get('js-scripts/controlled-checkboxes', [
        'as'   => 'js-scripts.sortable',
        'uses' => 'JSScriptsPresentationController@controlledCheckboxes',
    ]);

    // JS script notifications description page
    Route::get('js-scripts/notifications', [
        'as'   => 'js-scripts.notifications',
        'uses' => 'JSScriptsPresentationController@notifications',
    ]);

    // Notifications custom success response
    Route::post('js-scripts/notifications/popup', [
        'as'   => 'notifications.popup',
        'uses' => 'JSScriptsPresentationController@notificationsCustomResponsePopup',
    ]);

    // Notifications custom success response
    Route::post('js-scripts/notifications/custom-response', [
        'as'   => 'notifications.custom_response',
        'uses' => 'JSScriptsPresentationController@notificationsCustomResponse',
    ]);

    // JS script send ajax description page
    Route::get('js-scripts/send-ajax', [
        'as'   => 'js-scripts.send-ajax',
        'uses' => 'JSScriptsPresentationController@sendAjax',
    ]);

    // JS script bootstrap dateRangePicker description page
    Route::get('js-scripts/date-range-picker', [
        'as'   => 'js-scripts.date-range-picker',
        'uses' => 'JSScriptsPresentationController@dateRangePicker',
    ]);

    // JS script for input mask
    Route::get('js-scripts/input-mask', [
        'as'   => 'js-scripts.input-mask',
        'uses' => 'JSScriptsPresentationController@inputMask',
    ]);

    // JS script file uploader description page
    Route::get('js-scripts/file-uploader', [
        'as'   => 'js-scripts.file-uploader',
        'uses' => 'JSScriptsPresentationController@fileUploader',
    ]);

    // JS script add dynamic multifields complex description page
    Route::get('js-scripts/dynamic-multifields-complex', [
        'as'   => 'js-scripts.dynamic-multifields-complex',
        'uses' => 'JSScriptsPresentationController@dynamicMultiFieldsComplex',
    ]);

    // JS script add dynamic multifields simple description page
    Route::get('js-scripts/dynamic-multifields-simple', [
        'as'   => 'js-scripts.dynamic-multifields-simple',
        'uses' => 'JSScriptsPresentationController@dynamicMultiFieldsSimple',
    ]);

    // JS actions description page
    Route::get('js-actions', [
        'as'   => 'js-actions',
        'uses' => 'PresentationController@jsActions',
    ]);

    Route::get('js-actions/controlled-checkboxes', [
        'as'   => 'js-actions.controlled-checkboxes',
        'uses' => 'JSActionsPresentationController@controlledCheckboxes',
    ]);

    Route::get('js-actions/tooltips', [
        'as'   => 'js-actions.tooltips',
        'uses' => 'JSActionsPresentationController@tooltips',
    ]);

    Route::get('js-actions/confirmation-popup', [
        'as'   => 'js-actions.confirmation-popup',
        'uses' => 'JSActionsPresentationController@confirmationPopup',
    ]);

    Route::post('js-actions/confirmation-popup', [
        'as'   => 'js-actions.confirmation-popup-deleting',
        'uses' => 'JSActionsPresentationController@confirmationPopupDeleting',
    ]);

    Route::get('js-actions/content-copy-to-clipboard', [
        'as'   => 'js-actions.content-copy-to-clipboard',
        'uses' => 'JSActionsPresentationController@contentCopyToClipboard',
    ]);

    Route::get('js-actions/hide-show-on-click', [
        'as'   => 'js-actions.content-copy-to-clipboard',
        'uses' => 'JSActionsPresentationController@hideShowOnClick',
    ]);

    Route::get('js-actions/delete-with-confirmation', [
        'as'   => 'js-actions.delete-with-confirmation',
        'uses' => 'JSActionsPresentationController@deleteWithConfirmation',
    ]);

    Route::post('js-actions/delete-with-confirmation-deleting', [
        'as'   => 'js-actions.delete-with-confirmation-deleting',
        'uses' => 'JSActionsPresentationController@deleteWithConfirmationDeleting',
    ]);

    Route::get('js-actions/auto-update', [
        'as'   => 'js-actions.auto-update',
        'uses' => 'PresentationController@autoUpdate',
    ]);

    Route::get('js-actions/auto-update-button', [
        'as'   => 'js-actions.auto-update-button',
        'uses' => 'PresentationController@autoUpdateButton',
    ]);

    Route::get('js-actions/activity-controller', [
        'as'   => 'js-actions.activity-controller',
        'uses' => 'JSActionsPresentationController@activityController',
    ]);

    Route::get('js-actions/open-in-modal', [
        'as'   => 'js-actions.open-in-modal',
        'uses' => 'JSActionsPresentationController@openInModal',
    ]);

    Route::post('js-actions/open-in-modal-on-click', [
        'as'   => 'js-actions.open-in-modal-on-click',
        'uses' => 'JSActionsPresentationController@openInModalOnClick',
    ]);

    Route::post('js-actions/open-in-modal-on-change', [
        'as'   => 'js-actions.open-in-modal-on-change',
        'uses' => 'JSActionsPresentationController@openInModalOnChange',
    ]);

    Route::get('js-actions/send-request', [
        'as'   => 'js-actions.send-request',
        'uses' => 'JSActionsPresentationController@sendRequest',
    ]);

    Route::post('js-actions/process-send-request', [
        'as'   => 'js-actions.process-send-request',
        'uses' => 'JSActionsPresentationController@processSendRequest',
    ]);

    Route::post('js-actions/send-request-with-error', [
        'as'   => 'js-actions.send-request-with-error',
        'uses' => 'JSActionsPresentationController@requestWithError',
    ]);

    Route::post('js-actions/send-request-to-result-block', [
        'as'   => 'js-actions.send-request-to-result-block',
        'uses' => 'JSActionsPresentationController@sendRequestToResultBlock',
    ]);

    Route::post('js-actions/send-request-to-replace-block', [
        'as'   => 'js-actions.send-request-to-replace-block',
        'uses' => 'JSActionsPresentationController@sendRequestToReplaceBlock',
    ]);

    Route::get('js-actions/editable-text', [
        'as'   => 'js-actions.editable-text',
        'uses' => 'JSActionsPresentationController@editableText',
    ]);

    Route::post('js-actions/send-editable-text', [
        'as'   => 'js-actions.send-editable-text',
        'uses' => 'JSActionsPresentationController@editableTextProcess',
    ]);

    Route::get('mask', [
        'as'   => 'mask',
        'uses' => 'PresentationController@mask',
    ]);

    Route::get('mask-description', [
        'as'   => 'mask-description',
        'uses' => 'PresentationController@maskDescription',
    ]);

    // Notifications
	Route::get('notifications-description', [
		'as'   => 'notifications-desc',
		'uses' => 'PresentationController@notificationsDescription',
	]);

	// Notifications
	Route::get('notifications', [
		'as'   => 'notifications',
		'uses' => 'PresentationController@notifications',
	]);

	// date range
    Route::get('date-range', [
        'as'   => 'elements.date-range',
        'uses' => 'DateRangeController@example',
    ]);

	// date range js
    Route::get('date-range-js', [
        'as'   => 'elements.date-range-js',
        'uses' => 'DateRangeJsController@example',
    ]);

    // Play page
    Route::get('play', function (\Webmagic\Dashboard\Dashboard $dashboard) {
       $btn = (new \Webmagic\Dashboard\Elements\Links\LinkButton())->content('Sync with core entries')
           ->js()->sendRequestOnClick()->regular(url()->current(), [], 'GET', true, true, true);

        $dashboard->content($btn);

        return $dashboard;
    });

    Route::get('play/response', [
        'as'   => 'play.response',
        'uses' => function () {

            $data = [
                    'labels' => ['January', 'February', 'March', 'April', 'May'],
                    'datasets' => [
                        [
                            'label'               => 'label-item1 ',
                            'data'                => [28, 48, 40, 27, 40],
                        ],
                        [
                            'backgroundColor'     => '#f56954',
                            'borderColor'         => '#f56954',
                            'label'               =>  'label-item2',
                            'data'                =>  [28, 100, 15, 68, 90],
                        ]
                    ]
                ];

            return json_encode($data);

        },
    ]);

    Route::post('multifields-test', function (\Illuminate\Http\Request $request){

        $request->validate([
            'address.*' => 'int'
        ]);
        dd($request->all());
    });

    Route::post('complex-multifields-test', function (\Illuminate\Http\Request $request){

        $request->validate([
            'entity_given_name.*.address' => 'int'
        ]);
        dd($request->all());
    });

    Route::post('multifields-add', function (){
       return uniqid();
    });

    Route::delete('multifields-delete', function (){
        return 'OK';
    });

    Route::get('tmp-empty-page', function(){
        return view('dashboard::tech.empty_page');
    });

    // Input
    Route::get('input', [PresentationController::class, 'input'])->name('input');
    Route::get('password-input', [PresentationController::class, 'passwordInput'])->name('passwordInput');
    Route::get('text-input', [PresentationController::class, 'textInput'])->name('textInput');
    Route::get('slug-input', [PresentationController::class, 'slugInput'])->name('slugInput');
    Route::get('email-input', [PresentationController::class, 'emailInput'])->name('emailInput');
    Route::get('number-input', [PresentationController::class, 'numberInput'])->name('numberInput');
    Route::get('hidden-input', [PresentationController::class, 'hiddenInput'])->name('hiddenInput');
    Route::get('file-input', [PresentationController::class, 'fileInput'])->name('fileInput');
    Route::get('color-input', [PresentationController::class, 'colorInput'])->name('colorInput');

    Route::get('checkbox', [PresentationController::class, 'checkbox'])->name('checkbox');
    Route::get('switcher', [PresentationController::class, 'switcher'])->name('switcher');

    Route::get('textarea', [PresentationController::class, 'textarea'])->name('textarea');
    // Date and Time
    Route::get('date-input', [PresentationController::class, 'dateInput'])->name('dateInput');
    Route::get('time-input', [PresentationController::class, 'timeInput'])->name('timeInput');
    Route::get('date-time-picker', [PresentationController::class, 'dateTimePicker'])->name('dateTimePicker');
    Route::get('time-picker-js', [PresentationController::class, 'timePickerJs'])->name('timePickerJs');
    Route::get('date-time-picker-js', [PresentationController::class, 'dateTimePickerJS'])->name('dateTimePickerJS');
    Route::get('date-time-input', [PresentationController::class, 'dateTimeInput'])->name('dateTimeInput');
    // Selects
    Route::get('select', [PresentationController::class, 'select'])->name('select');
    Route::get('select-js', [PresentationController::class, 'selectJs'])->name('select-js');
    Route::get('select-with-autocomplete', [PresentationController::class, 'selectWithAutocomplete'])->name('select-with-autocomplete');

    Route::get('multifields-simple', [PresentationController::class, 'multifieldsSimple'])->name('multifields-simple');
    Route::get('multifields-complex', [PresentationController::class, 'multifieldsComplex'])->name('multifields-complex');

    // Other tech resources rendering
    Route::get('{template}', function ($template, \Webmagic\Dashboard\Dashboard $dashboard) {
        $data = [];

        if ($template == 'all') {
            $allFiles = scandir(__DIR__ . '/../resources/views/tech');
            $data['allFiles'] = $allFiles;
        }

        $template = "dashboard::tech.$template";
        if (view()->exists($template)) {
            $dashboard->content(view($template, $data));

            return $dashboard;
        }

        abort(404);
    });

    Route::post('uploadAjaxImage', [
        'as'   => 'uploadAjaxImage',
        'uses' => function () {
            $fileName = 'image.' . request()->file(['file'])->getClientOriginalExtension();

            $path = Storage::disk('public')->putFileAs('tmp', request()->file('file'), $fileName);

            $imgUrl = Storage::disk('public')->url($path);

            $imageComponent = (new \Webmagic\Dashboard\Elements\Files\ImageComponent())
                ->action('/dashboard/tech/uploadAjaxImage')
                ->addClass('col-6 col-md-4 col-lg-3')
                ->imgUrl($imgUrl)
                ->deleteMethod('DELETE')
                ->deleteAction('/dashboard/tech/deleteAjaxImage')
                ->size('10 Mb')->width('50')->height('14')
                ->title('Cool image component');

            return $imageComponent;
        },
    ]);

    Route::delete('deleteAjaxImage', [
        'as'   => 'deleteAjaxImage',
        'uses' => function () {
            $img = 'https://images.pexels.com/photos/414612/pexels-photo-414612.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500';

            $div = new \Webmagic\Dashboard\Elements\WrapperDiv();
            $div->addClass('some-class');

            $imageComponent = (new \Webmagic\Dashboard\Elements\Files\ImageComponent())
                ->action('/dashboard/tech/uploadAjaxImage')
                ->deleteMethod('DELETE')
                ->deleteAction('/dashboard/tech/deleteAjaxImage')
                ->addClass('col-6 col-md-4 col-lg-3')
                ->imgUrl($img)
                ->size('10 Mb')->width('50')->height('14')
                ->title('imageComponent');

            $div->addContent($imageComponent);
            return $div;
        },
    ]);
});

