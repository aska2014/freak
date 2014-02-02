<?php

$freakConfig = array_merge(freakRouteConfig(), array(
    'before' => 'freak'
));

$loginFreakConfig = array_merge(freakRouteConfig(), array(
    'before' => 'freak.login'
));

Route::group($loginFreakConfig, function()
{
    Route::controller('/login', 'Kareem3d\Freak\Controllers\LoginController');
    Route::controller('/register', 'Kareem3d\Freak\Controllers\RegisterController');
});

Route::group($freakConfig, function ()
{
    Route::get('/', array('as' => 'freak.home', 'uses' => 'Kareem3d\Freak\Controllers\FreakController@index'));

    Route::get('/pages/{page}.html', 'Kareem3d\Freak\Controllers\FreakController@page');


    // Request element view
    Route::get('/view/element/{element}/{view}', 'Kareem3d\Freak\Controllers\RequestController@elementView');

    // Request package view
    Route::get('/view/package/{package}/{view}', 'Kareem3d\Freak\Controllers\RequestController@packageView');


    // Request element operation
    Route::any('/element/{element}/{any?}', 'Kareem3d\Freak\Controllers\RequestController@element')
        ->where('element', '[a-zA-Z0-9]+')
        ->where('any', '.*');

    // Request package operation
    Route::any('/package/{package}/{any?}', 'Kareem3d\Freak\Controllers\RequestController@package')
        ->where('element', '[a-zA-Z0-9]+')
        ->where('any', '.*');


    Route::controller('/configuration', 'Kareem3d\Freak\Controllers\ConfigurationController');
});


Route::filter('freak', function()
{
    if(! Auth::user())
    {
        return Redirect::to(freakUrl('login'));
    }

    Auth::user()->failIfNoRole('administrator');
});


Route::filter('freak.login', function()
{
    if(Auth::user())
    {
        return Redirect::to(freakUrl('/'));
    }
});