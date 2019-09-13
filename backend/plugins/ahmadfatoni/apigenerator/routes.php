<?php

Route::post('fatoni/generate/api', array('as' => 'fatoni.generate.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@generateApi'));
Route::post('fatoni/update/api/{id}', array('as' => 'fatoni.update.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@updateApi'));
Route::get('fatoni/delete/api/{id}', array('as' => 'fatoni.delete.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@deleteApi'));

Route::resource('api/v1/eleve', 'AhmadFatoni\ApiGenerator\Controllers\API\eleveController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/eleve/{id}/delete', ['as' => 'api/v1/eleve.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\eleveController@destroy']);
Route::resource('api/v1/professeur', 'AhmadFatoni\ApiGenerator\Controllers\API\professeurController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/professeur/{id}/delete', ['as' => 'api/v1/professeur.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\professeurController@destroy']);
Route::resource('api/v1/note', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/note/{id}/delete', ['as' => 'api/v1/note.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@destroy']);
Route::resource('api/v1/parenteleve', 'AhmadFatoni\ApiGenerator\Controllers\API\parenteleveController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/parenteleve/{id}/delete', ['as' => 'api/v1/parenteleve.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\parenteleveController@destroy']);
Route::resource('api/v1/noteeleve', 'AhmadFatoni\ApiGenerator\Controllers\API\noteeleveController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/noteeleve/{id}/delete', ['as' => 'api/v1/noteeleve.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\noteeleveController@destroy']);
Route::resource('api/v1/users', 'AhmadFatoni\ApiGenerator\Controllers\API\userController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/users/{id}/delete', ['as' => 'api/v1/users.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\userController@destroy']);
Route::post('api/v1/users/login', ['as' => 'api/v1/users.login', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\userController@login']);