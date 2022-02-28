<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminCheck;
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
Route::prefix('app/')->middleware([AdminCheck::class])->group(function(){
    Route::post('create_tag' , 'AdminController@addTag');
    Route::get('get_tags' , 'AdminController@getTag');
    Route::post('edit_tag' , 'AdminController@editTag');
    Route::post('delete_tag' , 'AdminController@deleteTag');
    Route::post('upload' , 'AdminController@upload');
    Route::post('delete_image' , 'AdminController@deleteImage');

    Route::post('create_category' , 'AdminController@addCategory');
    Route::get('get_category' , 'AdminController@getCategory');
    Route::post('edit_category' , 'AdminController@editCategory');
    Route::post('delete_category', 'AdminController@deleteCategory');

    Route::post('create_user', 'AdminController@createUser');
    Route::get('get_users', 'AdminController@getUsers');
    Route::post('edit_user', 'AdminController@editUser');
    Route::post('admin_login', 'AdminController@adminLogin');

    //   Role Route
    Route::post('create_role', 'AdminController@createRole');
    Route::get('get_roles', 'AdminController@getRoles');
    Route::post('edit_role', 'AdminController@editRole');
    Route::post('assign_roles', 'AdminController@assignRoles');

    // blogs

    Route::post('create-blog' , 'AdminController@createBlog');

    Route::get('blogsdata' , 'AdminController@blogdata'); // Get the Blogs Items
    Route::post('delete_blog' , 'AdminController@deleteBlog');
    Route::get('blog_single/{id}' , 'AdminController@singleBlogItem');

});


Route::post('createBlog' ,'AdminController@uploadEditorImage');

Route::get('slug' , 'AdminController@slug');




Route::get('/' , 'AdminController@index');
Route::get('/logout' , 'AdminController@logout');
Route::any('{slug}', 'AdminController@index')->where('slug', '([A-z\d\-\/_.]+)?');





// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('json' , 'TestController@testcontroller');

// Route::any('{slug}', function() {
//     return view('welcome');
// });
