<?php
Route::get('/', 'AuthController@index');
Route::get('login', 'AuthController@form');
Route::post('login', 'AuthController@authenticate');

Route::get('/schedule', 'ScheduleController@index');

Route::get('/subscribers', 'SubscribersController@index');
Route::post('/subscribers', 'SubscribersController@create');
Route::get('/subscribers/create', 'SubscribersController@showForm');

Route::get('/api/messages', 'ApiController@messages');