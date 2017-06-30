<?php
Route::post('user/role/bundle', '\$NAME$\User\Controllers\RoleController@bundle');
Route::resource('user/role', '\$NAME$\User\Controllers\RoleController');

Route::post('user/permission/bundle', '\$NAME$\User\Controllers\PermissionController@bundle');
Route::resource('user/permission', '\$NAME$\User\Controllers\PermissionController');

Route::post('user/bundle', '\$NAME$\User\Controllers\UserController@bundle');
Route::resource('user', '\$NAME$\User\Controllers\UserController');
