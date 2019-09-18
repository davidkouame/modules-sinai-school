<?php

Route::post('fatoni/generate/api', array('as' => 'fatoni.generate.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@generateApi'));
Route::post('fatoni/update/api/{id}', array('as' => 'fatoni.update.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@updateApi'));
Route::get('fatoni/delete/api/{id}', array('as' => 'fatoni.delete.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@deleteApi'));

Route::resource('api/v1/noteseleves', 'AhmadFatoni\ApiGenerator\Controllers\API\noteselevesController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/noteseleves/{id}/delete', ['as' => 'api/v1/noteseleves.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\noteselevesController@destroy']);
Route::resource('api/v1/notemodel', 'AhmadFatoni\ApiGenerator\Controllers\API\noteController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/notemodel/{id}/delete', ['as' => 'api/v1/notemodel.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\noteController@destroy']);
Route::resource('api/v1/classes', 'AhmadFatoni\ApiGenerator\Controllers\API\classesController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/classes/{id}/delete', ['as' => 'api/v1/classes.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\classesController@destroy']);
Route::resource('api/v1/absenceseleves', 'AhmadFatoni\ApiGenerator\Controllers\API\absenceselevesController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/absenceseleves/{id}/delete', ['as' => 'api/v1/absenceseleves.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\absenceselevesController@destroy']);
Route::resource('api/v1/users', 'AhmadFatoni\ApiGenerator\Controllers\API\userController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/users/{id}/delete', ['as' => 'api/v1/users.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\userController@destroy']);
Route::resource('api/v1/professeurs', 'AhmadFatoni\ApiGenerator\Controllers\API\professeurController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/professeurs/{id}/delete', ['as' => 'api/v1/professeurs.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\professeurController@destroy']);
Route::resource('api/v1/eleves', 'AhmadFatoni\ApiGenerator\Controllers\API\eleveController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/eleves/{id}/delete', ['as' => 'api/v1/eleves.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\eleveController@destroy']);
Route::resource('api/v1/raisonsabsences', 'AhmadFatoni\ApiGenerator\Controllers\API\raisonabsenceController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/raisonsabsences/{id}/delete', ['as' => 'api/v1/raisonsabsences.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\raisonabsenceController@destroy']);