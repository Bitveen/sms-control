<?php

/* Авторизация */
Route::get('/', 'AuthController@index');
Route::get('/login', 'AuthController@form');
Route::post('/login', 'AuthController@authenticate');
Route::get('/logout', 'AuthController@logout');



Route::get('/schedule', 'ScheduleController@index');


Route::get('/breaks/create', 'BreaksController@showForm');
Route::post('/breaks', 'BreaksController@create');
Route::get('/breaks/{id}', 'BreaksController@view');
Route::post('/breaks/{id}', 'BreaksController@update');

/* Подписчики */
Route::get('/subscribers', 'SubscribersController@index');
Route::post('/subscribers', 'SubscribersController@create');
Route::get('/subscribers/create', 'SubscribersController@showForm');
Route::get('/subscribers/{id}', 'SubscribersController@view')
    ->where('id', '[0-9]+');
Route::post('/subscribers/{id}', 'SubscribersController@update')
    ->where('id', '[0-9]+');



/* AJAX запросы */
Route::get('/api/breaks', 'ApiController@getBreaks');
Route::post('/api/breaks/{id}', 'ApiController@updateBreak');
Route::post('/api/subscribers/drop', 'ApiController@dropSubscriber');
Route::post('/api/breaks/drop/{id}', 'ApiController@dropBreak');

Route::post('/api/messages', 'ApiController@parseMessage');