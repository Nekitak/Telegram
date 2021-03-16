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
 
  
Route::get('/admin', [App\Http\Controllers\Backend\DashboardController::class, 'index'])->name('admin');


Route::match(['post', 'get'], 'register', function(){ 
    return redirect('/');
})->name('register');

 

Route::middleware(['auth'])->prefix('admin')->namespace('App\Http\Controllers\Backend')->name('admin.')->group( function(){
    Route::get('/', 'DashboardController@index')->name('index'); 

    Route::get('/dashboard/configurator', 'DashboardController@configurator')->name('dashboard.configurator');
});


Auth::routes();