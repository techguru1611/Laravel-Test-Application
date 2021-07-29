<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('organization');
});

Route::get('/organization',  'App\Http\Controllers\OrganizationController@index')->name('organizations');
Route::get('/organization/add',  'App\Http\Controllers\OrganizationController@create')->name('addViewOrganizations');
Route::post('/store-organization/{id?}',  'App\Http\Controllers\OrganizationController@store')->name('storeOrganization');
Route::post('/delete-organization/{id}', 'App\Http\Controllers\OrganizationController@destroy')->name('deleteOrganization');
Route::get('/organization/view/{id}', 'App\Http\Controllers\OrganizationController@show')->name('viewOrganization');
Route::get('/organization/edit/{id}', 'App\Http\Controllers\OrganizationController@edit')->name('editOrganization');

// routes for Contacts
Route::get('/contact','App\Http\Controllers\ContactsController@index')->name('contact');
Route::get('/contact/add','App\Http\Controllers\ContactsController@create')->name('addViewContact');
Route::post('/store-contact/{id?}',  'App\Http\Controllers\ContactsController@store')->name('storeContact');
Route::post('/delete-contact/{id}', 'App\Http\Controllers\ContactsController@destroy')->name('deleteContact');
Route::get('/contact/view/{id}', 'App\Http\Controllers\ContactsController@show')->name('viewContact');
Route::get('/contact/edit/{id}', 'App\Http\Controllers\ContactsController@edit')->name('editContact');
Route::get('/contact/verify/{id}', 'App\Http\Controllers\ContactsController@verifyUser');
