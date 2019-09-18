<?php

Route::get('api/v1/noteeleves', 'BootnetCrasher\School\Controllers\Api\NoteEleveController@searchEleves')->name('eleves.search');
Route::post('api/v1/users/login', ['as' => 'api/v1/users.login', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\userController@login']);