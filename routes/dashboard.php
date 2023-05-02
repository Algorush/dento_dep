<?php

Route::group([
    'as' => 'dashboard::',
    'prefix' => 'dashboard',
    'namespace' => 'Dashboard',
    'middleware' => ['auth', 'dashboard'],
], function () {

    Route::get('/', 'MainDashboardController@index')->name('index');


    Route::group([
        'middleware' => ['can:crud-sellers'],
    ], function () {
        /*
         * Sellers crud
        */
        Route::resources(['sellers' => 'SellerDashboardController'], ['except' => ['show']]);
    });

    /*
     * Edit Account By Seller
     */
    Route::group([
        'prefix' => 'account'
    ], function () {
        Route::get('', 'UserDashboardController@editAccount')->name('account');
        Route::put('{user}', 'UserDashboardController@updateAccount')->name('account.update');
    });


    /*
     * Clients crud
     */
    Route::group([
        'prefix' => 'clients',
        'as' => 'clients.',
        'middleware' => ['can:read-create-edit-clients'],
    ], function () {

        Route::get('{seller?}', 'ClientDashboardController@index')->name('index');
        Route::get('create/for-seller/{seller_id}', 'ClientDashboardController@create')->name('create');
        Route::post('', 'ClientDashboardController@store')->name('store');
        Route::get('{client}/edit', 'ClientDashboardController@edit')->name('edit');
        Route::put('{client}', 'ClientDashboardController@update')->name('update');

        Route::delete('{client}', 'ClientDashboardController@destroy')->name('destroy')->middleware(['can:delete-clients']);
    });

    /*
    * Clients crud
    */
    Route::group([
        'prefix' => 'deals',
        'as' => 'deals.',
        'middleware' => ['can:read-create-edit-deals'],
    ], function () {

        Route::get('all/client/{client?}', 'DealDashboardController@indexByClient')->name('index-by-client');
        Route::get('all/seller/{seller?}', 'DealDashboardController@indexBySeller')->name('index-by-seller');
        Route::get('create/for-client/{client?}', 'DealDashboardController@createByClient')->name('create-by-client');
        Route::get('create/for-seller/{seller?}', 'DealDashboardController@createBySeller')->name('create-by-seller');
        Route::post('', 'DealDashboardController@store')->name('store');
        Route::get('{deal}/edit/{file_type?}', 'DealDashboardController@edit')->name('edit');
        Route::put('{deal}', 'DealDashboardController@update')->name('update');

        Route::delete('{deal}', 'DealDashboardController@destroy')->name('destroy')->middleware(['can:delete-deals']);

        Route::get('{deal}/add-file/{file_type}', 'DealDashboardController@addUpperOrLowerFile')->name('add-file');
        Route::post('{deal}/save-file/{file_type}', 'DealDashboardController@saveUpperOrLowerFile')->name('save-file');
        Route::delete('{file_type}/delete-file/{file}', 'DealDashboardController@destroyUpperOrLowerFile')->name('destroy-file');
        Route::post('{file_type}/position-file', 'DealDashboardController@updatePositionUpperOrLowerFile')->name('position-file');

        Route::post('notifications', 'DealDashboardController@notifications')->name('notifications');
    });


    /*
     * Trash
     */
    Route::group([
        'middleware' => ['can:admin'],
        'prefix' => 'trash',
        'as' => 'trash.',
    ], function () {
        Route::get('', 'TrashDashboardController@index')->name('index');
        Route::post('{user}/restore/user', 'TrashDashboardController@restoreUser')->name('restore-user');
        Route::post('{case}/restore/case', 'TrashDashboardController@restoreCase')->name('restore-case');
        Route::delete('{user}/user', 'TrashDashboardController@destroyUser')->name('destroy-user');
        Route::delete('{user}/case', 'TrashDashboardController@destroyCase')->name('destroy-case');

        Route::get('sellers', 'TrashDashboardController@getSellersTable')->name('sellers');
        Route::get('clients', 'TrashDashboardController@getClientsTable')->name('clients');
        Route::get('cases', 'TrashDashboardController@getCasesTable')->name('cases');
    });
});


Route::group([
    'prefix'     => 'dashboard/api',
    'as'         => 'dashboard.api.',
    'namespace'  => 'Dashboard',
], function () {
    Route::post('image/{field_name}', [
        'as' => 'image.upload',
        'uses' => 'ImagesController@upload'
    ]);
});
