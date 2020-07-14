<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function() {
    return view('welcome');
})->name('/');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/users', 'UserController@index')->name('admin.users.index');
    Route::get('/users/create', 'UserController@create')->name('admin.users.create');
    Route::post('/users/store', 'UserController@store')->name('admin.users.store');
    Route::get('/users/{userId}/edit', 'UserController@edit')->name('admin.users.edit');
    Route::put('/users/{userId}/update', 'UserController@update')->name('admin.users.update');

    Route::get('/permissions', 'PermissionController@index')->name('admin.permissions.index');
    Route::get('/permissions/create', 'PermissionController@create')->name('admin.permissions.create');
    Route::post('/permissions/store', 'PermissionController@store')->name('admin.permissions.store');
    Route::get('/permissions/{permissionId}/edit', 'PermissionController@edit')->name('admin.permissions.edit');
    Route::put('/permissions/{permissionId}/update', 'PermissionController@update')->name('admin.permissions.update');
    Route::delete('/permissions/{permissionId}/delete', 'PermissionController@destroy')->name('admin.permissions.delete');

    Route::get('/roles', 'RoleController@index')->name('admin.roles.index');
    Route::get('/roles/create', 'RoleController@create')->name('admin.roles.create');
    Route::post('/roles/store', 'RoleController@store')->name('admin.roles.store');
    Route::get('/roles/{roleId}/edit', 'RoleController@edit')->name('admin.roles.edit');
    Route::put('/roles/{roleId}/update', 'RoleController@update')->name('admin.roles.update');
    Route::delete('/roles/{roleId}/delete', 'RoleController@destroy')->name('admin.roles.delete');
    Route::get('/roles/{roleId}', 'RoleController@show')->name('admin.roles.show');
    Route::put('/roles/{roleId}/permission', 'RolePermissionController@update')->name('admin.roles.permissions.update');
});
