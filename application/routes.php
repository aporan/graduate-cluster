<?php

/*  Logging page */
Route::get('login', array('as'=>'login', 'uses'=>'authentication@view_login'));
Route::post('login/create', array('before'=>'csrf', 'uses'=>'authentication@login'));
Route::post('logout', array('before'=>'csrf', 'uses'=>'authentication@logout'));
Route::get('verify', array('as'=>'verify', 'uses'=>'authentication@view_verify'));
Route::post('verify/email', array('before'=>'csrf', 'uses'=>'authentication@verify'));
Route::get('reset', array('as'=>'reset', 'uses'=>'authentication@view_reset'));
Route::post('reset/password', array('before'=>'csrf', 'uses'=>'authentication@reset'));

/*  Register page */
Route::get('register', array('as'=>'register', 'uses'=>'authentication@view_register'));
Route::post('register/create', array('before'=>'csrf', 'uses'=>'authentication@register'));

Route::group(array('before'=>'auth'), function() {
    /* Static Pages */
    Route::get('/', array('as'=>'index', 'uses'=>'staticpages@index'));
    Route::get('email/new', array('as'=>'email_index', 'uses'=>'staticpages@email_index'));
    Route::post('email/send', array('before'=>'csrf', 'uses'=>'staticpages@email_send'));
    
    /* Booking Routes */
    Route::get('booking/new', array('as'=>'new_booking', 'uses'=>'booking@new'));
    Route::get('booking/pagetwo', array('as' => 'new_pagetwo', 'uses' => 'booking@pagetwo'));
    Route::get('booking/pagethree', array('as' => 'new_pagethree', 'uses' => 'booking@pagethree'));
    Route::post('booking/pageone', array('before'=>'csrf', 'uses'=>'booking@pageone'));
    Route::post('booking/pagetwo', array('before'=>'csrf', 'uses'=>'booking@pagetwo'));
    Route::post('booking/create', array('before'=>'csrf', 'uses'=>'booking@create'));
    Route::get('booking/(:any)/edit', array('as'=>'edit_booking', 'uses'=>'booking@edit'));
    Route::put('booking/update', array('before'=>'csrf', 'uses'=>'booking@update'));
    Route::delete('booking/delete', array('uses'=>'booking@remove'));

    /* Change Request Routes*/
    Route::get('requestchange', array('as'=>'change_index','uses'=>'requestchange@index'));
    Route::get('requestchange/pagetwo', array('as'=>'change_pagetwo', 'uses'=>'requestchange@pagetwo'));
    Route::get('requestchange/(:any)/new', array('as'=>'new_change', 'uses'=>'requestchange@new'));
    Route::post('requestchange/pageone', array('before'=>'csrf', 'uses'=>'requestchange@pageone'));
    Route::post('requestchange/update', array('before'=>'csrf', 'uses'=>'requestchange@update'));
});

Route::group(array('before'=>'admin|auth'), function() {

    Route::get('admin', array('as'=>'admin_index', 'uses'=>'staticpages@admin_index'));

    /* User management page */
    Route::get('manager', array('as'=>'manager_index', 'uses'=>'usermanager@index'));
    Route::get('manager/(:any)/assign', array('as'=>'assign_users', 'uses'=>'usermanager@view_assign'));
    Route::post('manager/assign', array('before'=>'csrf', 'uses'=>'usermanager@assign'));
    Route::post('manager/unassign', array('before'=>'csrf', 'uses'=>'usermanager@unassign'));

    /* Cluster Routes */
    Route::get('clusters', array('as'=>'clusters', 'uses'=>'cluster@index'));
    Route::get('cluster/new', array('as'=>'new_cluster', 'uses'=>'cluster@new'));
    Route::post('cluster/create', array('before'=>'csrf', 'uses'=>'cluster@create'));
    Route::get('cluster/(:any)/edit', array('as'=>'edit_cluster', 'uses'=>'cluster@edit'));
    Route::put('cluster/update', array('before'=>'csrf', 'uses'=>'cluster@update'));
    Route::delete('cluster/delete', array('uses'=>'cluster@remove'));

    /* Seat Routes */
    Route::get('cluster/(:any)/seats', array('as'=>'cluster_seats', 'uses'=>'seat@index'));
    Route::get('seat/new', array('as'=>'new_seat', 'uses'=>'seat@new'));
    Route::post('seat/create', array('before'=>'csrf', 'uses'=>'seat@create'));
    Route::delete('seat/delete', array('uses'=>'seat@remove'));
    
});

/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function(){ return Response::error('404'); });

Event::listen('500', function(){ return Response::error('500'); });

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Route::get('/', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('admin', function() {
    $current_user = Auth::user();
    $user_type = $current_user->type;
    $is_admin = ($user_type == 'admin') ? True : False;
    if (!$is_admin) {  return Response::error('403');  }
});

Route::filter('before', function(){
	// Do stuff before every request to your application...
});

Route::filter('after', function($response){
	// Do stuff after every request to your application...
});

Route::filter('csrf', function(){ if (Request::forged()) return Response::error('500'); });

Route::filter('auth', function(){ if (Auth::guest()) return Redirect::to('login'); });