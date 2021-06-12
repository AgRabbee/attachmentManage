<?php
Route::get('/', function () {
    return view('welcome');
});

Route::post('/image/convertToBase64', 'ImageController@convertToBase64');
Route::post('/image/convertToRawImg', 'ImageController@convertToRawImg');
Route::post('/image/generateUrlForImg', 'ImageController@generateUrlForImg');
Route::get('/image_url', 'ImageController@imgFromURL');
Route::post('/exclToDB', 'ImageController@exclToDB');
