<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CustomerController;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Gate;


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

Auth::routes();

//Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Roles

Route::middleware(['auth'])->group(function(){
    Route::get('/roles', [RolesController::class, 'index'])->name('roles.index');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/roles/create', [RolesController::class,'create'])->name('roles.create');
    Route::post('/roles/create', [RolesController::class,'store'])->name('roles.store');
});

Route::middleware(['auth'])->group(function(){
   Route::get('/roles/{role}/edit', [RolesController::class,'edit'])->name('roles.edit');
    Route::post('/roles/{role}/edit', [RolesController::class,'update'])->name('roles.update');
});


//Route::get('/roles/{role}/edit', [RolesController::class,'edit'])->name('roles.edit');

Route::get('/force-login', function () {
    return 'Logged in as ' . Auth::user()->role;
});

Route::middleware(['auth'])->group(function(){
    Route::get('/roles/{id}/delete', [RolesController::class,'destroy'])->name('roles.delete');
});

/* Route::get('/test-policy/{role}', function (\App\Models\Roles $role) {
    dd('Route works, role:', $role->id , ", Role name: " , $role->name);
}); */

//Users
Route::middleware(['auth'])->group(function(){
    Route::get('/users', [UsersController::class,'index'])->name('users.index');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/users/create', [UsersController::class,'create'])->name('users.create');
    Route::post('/users/create', [UsersController::class,'store'])->name('users.store');
});

Route::middleware(['auth'])->group(function(){
    Route::get('/users/{id}/edit', [UsersController::class,'edit'])->name('users.edit');
    Route::post('/users/{id}/edit', [UsersController::class,'update'])->name('users.update');
});

Route::middleware(['auth', 'permission:users.delete'])->group(function(){
    Route::get('/users/{id}/delete', [UsersController::class,'destroy'])->name('users.delete');
});

//Customer
Route::middleware(['auth', 'permission:customer.view'])->group(function(){
    Route::get('/customer', [CustomerController::class,'index'])->name('customer.index');
});


