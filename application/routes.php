<?php

/* Static Pages */
Route::get('/', array('as'=>'index', 'uses'=>'staticpages@index'));
Route::get('admin', array('as'=>'admin_index', 'uses'=>'staticpages@admin_index'));
/* Temp log in page */
Route::get('login', array('uses'=>'staticpages@login'));

/* Cluster Routes */
Route::get('clusters', array('as'=>'clusters', 'uses'=>'cluster@index'));
Route::get('cluster/new', array('as'=>'new_cluster', 'uses'=>'cluster@new'));
Route::post('cluster/create', array('uses'=>'cluster@create'));
Route::get('cluster/(:any)/edit', array('as'=>'edit_cluster', 'uses'=>'cluster@edit'));
Route::put('cluster/update', array('uses'=>'cluster@update'));
Route::delete('cluster/delete', array('uses'=>'cluster@remove'));

/* Seat Routes */
Route::get('cluster/(:any)/seats', array('as'=>'cluster_seats', 'uses'=>'seat@index'));
Route::get('seat/new', array('as'=>'new_seat', 'uses'=>'seat@new'));
Route::post('seat/create', array('before'=>'csrf', 'uses'=>'seat@create'));
Route::delete('seat/delete', array('uses'=>'seat@remove'));

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

Route::filter('before', function(){
	// Do stuff before every request to your application...
});

Route::filter('after', function($response){
	// Do stuff after every request to your application...
});

Route::filter('csrf', function(){ if (Request::forged()) return Response::error('500'); });

Route::filter('auth', function(){ if (Auth::guest()) return Redirect::to('login'); });