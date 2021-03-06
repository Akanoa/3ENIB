<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', function(){
	Session::set("headerTitle", "Accueil");
	return View::make("home");
});

Route::resource('company', 'CompanyController');

Route::controller('project', 'ProjectController');
Route::controller('post', 'PostController');
Route::controller('user', 'UserController');
Route::controller('document', 'DocumentController');
Route::controller('student', 'StudentController');
// Route::controller('password', 'RemindersController');