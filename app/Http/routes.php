<?php

/* Авторизация */
Route::get('/', 'AuthController@index');
Route::get('/login', 'AuthController@form');
Route::post('/login', 'AuthController@authenticate');
Route::get('/logout', 'AuthController@logout');



Route::get('/schedule', 'ScheduleController@index');


/* Подписчики */
Route::get('/subscribers', 'SubscribersController@index');
Route::post('/subscribers', 'SubscribersController@create');
Route::get('/subscribers/create', 'SubscribersController@showForm');
Route::get('/subscribers/{id}', 'SubscribersController@view')
    ->where('id', '[0-9]+');
Route::post('/subscribers/{id}', 'SubscribersController@update')
    ->where('id', '[0-9]+');



Route::get('/api/breaks', 'ScheduleController@getBreaks');