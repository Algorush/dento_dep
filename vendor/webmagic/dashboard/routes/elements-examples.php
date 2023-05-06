<?php

// Flexible Date Dropdown element
Route::get('flexible-date-time-picker', [
    'as'   => 'flexible-date-time-picker',
    'uses' => 'PresentationController@flexibleDateTimePicker',
]);

// Date Dropdown element
Route::get('images', [
    'as'   => 'images',
    'uses' => 'PresentationController@imageDisplaying',
]);

// Autoupdate element
Route::get('auto-update', [
    'as'   => 'auto-update',
    'uses' => 'PresentationController@autoUpdate',
]);

// Autocomplete element
Route::get('select-autocomplete', [
    'as'   => 'select-autocomplete',
    'uses' => 'PresentationController@autoComplete',
]);

//BreadCrumbs
Route::get('breadcrumbs', [
    'as'   => 'breadcrumbs',
    'uses' => 'PresentationController@breadcrumbs',
]);

// Photos uploading plugin
Route::match(['get', 'post', 'delete'], 'photo-uploading', [
    'as'   => 'photo-uploading',
    'uses' => 'PresentationController@photoUploading',
]);

// Main menu
Route::get('main-menu', [
    'as'   => 'main-menu',
    'uses' => 'PresentationController@mainMenu',
]);

// Top menu
Route::get('top-menu', [
    'as'   => 'top-menu',
    'uses' => 'PresentationController@topMenu',
]);

Route::get('top-menu/presentation-mode', [
    'as'   => 'top-menu-presentation-mode',
    'uses' => 'PresentationController@topMenuPresentationMode',
]);

// Visual editor
Route::get('visual-editor', [
    'as'   => 'visual-editor',
    'uses' => 'PresentationController@visualEditor',
]);

Route::any('visual-editor/on-blur', [
    'as'   => 'visual-editor.on-blur',
    'uses' => 'PresentationController@visualEditorOnBlur',
]);

// Box
Route::get('box', [
    'as'   => 'box',
    'uses' => 'PresentationController@box',
]);

// Widgets
Route::get('simple-widget', [
    'as'   => 'simple-widget',
    'uses' => 'PresentationController@simpleWidget',
]);

Route::get('progress-widget', [
    'as'   => 'progress-widget',
    'uses' => 'PresentationController@progressWidget',
]);

Route::get('box-widget', [
    'as'   => 'box-widget',
    'uses' => 'PresentationController@boxWidget',
]);

// SelectJs validation
Route::post('select-js-choose-option', [
    'as'   => 'select-js-choose-option',
    'uses' => 'PresentationController@selectJsChooseOption',
]);
