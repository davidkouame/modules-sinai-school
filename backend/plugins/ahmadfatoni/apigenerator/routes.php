<?php

Route::post('fatoni/generate/api', array('as' => 'fatoni.generate.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@generateApi'));
Route::post('fatoni/update/api/{id}', array('as' => 'fatoni.update.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@updateApi'));
Route::get('fatoni/delete/api/{id}', array('as' => 'fatoni.delete.api', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\ApiGeneratorController@deleteApi'));

Route::resource('api/v1/noteseleves', 'AhmadFatoni\ApiGenerator\Controllers\API\noteselevesController', ['except' => ['destroy', 'create', 'edit']]);
Route::get('api/v1/noteseleves/{id}/delete', ['as' => 'api/v1/noteseleves.delete', 'uses' => 'AhmadFatoni\ApiGenerator\Controllers\API\noteselevesController@destroy']);