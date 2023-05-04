<?php

use App\Http\Controllers\User\UserListController;
use App\Http\Controllers\User\UserListPermissionController;
use App\Http\Livewire\User\UserList\Index;
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

Route::middleware(['auth'])->group(function () {
    Route::name('user.')->prefix('user')->group(function (){
        Route::get('/list/{user}',Index::class)->name('list.index');
        Route::resource('listPermission',UserListPermissionController::class)->except(['show','edit','update']);
    });

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
