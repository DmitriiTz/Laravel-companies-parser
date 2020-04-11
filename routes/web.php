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
    return view('welcome');
});

Route::get('link', 'LinkController@start')->name('links');
Route::get('comp', 'CompanyController@start')->name('companies');
Route::post('login', 'LoginController@login')->name('login');

Route::get('mail', 'EmailController@sendEmail');
