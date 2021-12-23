<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Nouploadw create something great!
|
*/


Route::post('app/create_tag' , 'AdminController@addTag');
Route::get('app/get_tags' , 'AdminController@getTag');
Route::post('app/edit_tag' , 'AdminController@editTag');
Route::post('app/delete_tag' , 'AdminController@deleteTag');
Route::post('app/upload' , 'AdminController@upload');
Route::post('app/delete_image' , 'AdminController@deleteImage');


Route::post('app/create_category' , 'AdminController@addCategory');
Route::get('app/get_cagegory' , 'AdminController@getCategory');
Route::post('app/edit_category' , 'AdminController@editCategory');
Route::post('app/delete_category', 'AdminController@deleteCategory');


Route::post('app/create_user', 'AdminController@createUser');
Route::get('app/get_users', 'AdminController@getUsers');
Route::post('app/edit_user', 'AdminController@editUser');
Route::post('app/admin_login', 'AdminController@adminLogin');



Route::get('/' , 'AdminController@index');
Route::get('/logout' , 'AdminController@logout');
Route::any('{slug}' , 'AdminController@index');





// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('json' , 'TestController@testcontroller');

// Route::any('{slug}', function() {
//     return view('welcome');
// });
