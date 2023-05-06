<?php

/** Table page generation full example */
Route::match(['get', 'post'], 'table-page', [
    'as'   => 'table-page',
    'uses' => 'PresentationController@tablePage',
]);
Route::get('table-page-description', [
    'as'   => 'table-page-description',
    'uses' => 'PresentationController@tablePageDescription',
]);

/** Tiles list page */
Route::get('tiles-list-page', [
    'as'   => 'tiles-list-page',
    'uses' => 'PresentationController@tilesListPage',
]);
Route::get('tiles-list-page-description', [
    'as'   => 'tiles-list-page-description',
    'uses' => 'PresentationController@tilesListPageDescription',
]);

/** Form Page Generation */
Route::get('page-generator', [
    'as'   => 'page-generator',
    'uses' => 'PresentationController@formPageGenerator',
]);

/** Form page generation full example */
Route::get('form-group', [
    'as'   => 'form-group',
    'uses' => 'PresentationController@formPageGeneratorWithFormGroup',
]);

/** Login page generation example */
Route::get('login-page', [
    'as'   => 'login-page',
    'uses' => 'PresentationController@loginPageDescription',
]);
Route::get('login-page-demo', [
    'as'   => 'login-page-demo',
    'uses' => 'PresentationController@loginPageDemo',
]);

Route::get('blank-page', [
    'as'   => 'blank-page',
    'uses' => 'PresentationController@blankPageDescription',
]);

Route::get('blank-page-example', [
    'as'   => 'blank-page-example',
    'uses' => 'PresentationController@blankPageDescriptionExample',
]);

/** change admin panel style docs */
Route::get('change-admin-panel-style-description', [
    'as'   => 'change-admin-panel-style-description',
    'uses' => 'PresentationController@adminPanelStyleDescription',
]);

Route::get('small-notifications', [
    'as'   => 'small-notifications',
    'uses' => 'PresentationController@smallNotificationsDescription',
]);

Route::get('middleware', [
    'as'   => 'middleware',
    'uses' => 'PresentationController@middleware',
]);

Route::get('multifields', [
    'as'   => 'multifields',
    'uses' => 'PresentationController@multifields',
]);

Route::get('lists', [
    'as'   => 'lists',
    'uses' => 'PresentationController@lists',
]);

Route::get('image', [
    'as'   => 'image',
    'uses' => 'PresentationController@image',
]);

Route::get('badge', [
    'as'   => 'badge',
    'uses' => 'PresentationController@badge',
]);

Route::get('wrappers', [
    'as'   => 'wrappers',
    'uses' => 'PresentationController@wrappers',
]);

Route::get('tabs', [
    'as'   => 'tabs',
    'uses' => 'PresentationController@tabs',
]);

Route::get('grid', [
    'as'   => 'grid',
    'uses' => 'PresentationController@grid',
]);

Route::get('links', [
    'as'   => 'links',
    'uses' => 'PresentationController@links',
]);

Route::get('progressbar', [
    'as' => 'progressbar',
    'uses' => 'PresentationController@progressbar',
]);

/** Graphic example */
Route::get('graphic', [
    'as'   => 'graphic',
    'uses' => 'PresentationController@graphic',
]);

Route::post('custom-success-response', [
    'as'   => 'custom_success_response',
    'uses' => 'PresentationController@customSuccessResponse',
]);