<?php

Route::group([
    'prefix' => 'tables',
    'as' => 'tables.'
], function (){
    Route::get('manual-sorting', [
        'as'   => 'manual-sorting',
        'uses' => 'TablePresentationController@manualSortingDocs',
    ]);

    Route::get('manual-sorting-example', [
        'as'   => 'manual-sorting-example',
        'uses' => 'TablePresentationController@manualSortingExample',
    ]);

    Route::get('sorting', [
        'as'   => 'sorting',
        'uses' => 'TablePresentationController@sortingDocs',
    ]);

    Route::get('choose-columns', [
        'as'   => 'choose-columns',
        'uses' => 'TablePresentationController@chooseColumnsDocs',
    ]);

    /** pagination docs */
    Route::get('pagination', [
        'as'   => 'pagination',
        'uses' => 'TablePresentationController@pagination',
    ]);

    Route::get('pagination/base-using', [
        'as'   => 'paginationBaseUsing',
        'uses' => 'TablePresentationController@paginationBaseUsing',
    ]);

    Route::get('pagination/base-using-with-dropdown', [
        'as'   => 'paginationBaseUsingWithDropdown',
        'uses' => 'TablePresentationController@paginationBaseUsingWithDropdown',
    ]);

    Route::get('pagination/with-custom-per-page', [
        'as'   => 'paginationWithCustomPerPage',
        'uses' => 'TablePresentationController@paginationWithCustomPerPage',
    ]);

    Route::get('pagination/with-two-tables', [
        'as'   => 'paginationWithTwoTables',
        'uses' => 'TablePresentationController@paginationWithTwoTablesAndFilters',
    ]);

    Route::get('pagination/first-table', [
        'as'   => 'paginationFirstTableAndFilter',
        'uses' => 'TablePresentationController@paginationFirstTableAndFilter',
    ]);

    Route::get('pagination/second-table', [
        'as'   => 'paginationSecondTableAndFilter',
        'uses' => 'TablePresentationController@paginationSecondTableAndFilter',
    ]);
});

