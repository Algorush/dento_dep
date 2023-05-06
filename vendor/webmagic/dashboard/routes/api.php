<?php

Route::group([
    'prefix'     => 'dashboard/api',
    'as'         => 'dashboard.api.',
    'namespace'  => 'Webmagic\Dashboard\Api\Http',
    'middleware' => config('webmagic.dashboard.dashboard.api_middleware'),
], function () {
    /**
     * Images API
     */
    Route::post('image/{field_name}', [
       'as' => 'image.upload',
       'uses' => 'ImagesController@upload'
    ]);

    Route::delete('image', [
        'as' => 'image.delete',
        'uses' => 'ImagesController@delete'
    ]);

    Route::post('set-locale', [
        'as' => 'set-locale',
        'uses' => 'SettingsController@setLocale'
    ]);

    Route::post('columns', [
        'as' => 'columns',
        'uses' => 'TablePageController@getColumnList'
    ]);
});
