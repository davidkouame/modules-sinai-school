<?php

Route::get('api/v1/noteeleves', 'BootnetCrasher\School\Controllers\Api\NoteEleveController@searchEleves')->name('eleves.search');
Route::get('api/v1/professeursclasses', 'BootnetCrasher\School\Controllers\Api\ProfesseursClasses@searchProfesseursClasses')->name('professeursclasses.search');
Route::post('api/v1/users/login', ['as' => 'api/v1/users.login', 'uses' => 'BootnetCrasher\School\Controllers\Api\userController@login']);
Route::post('api/v1/users/update', ['as' => 'api/v1/users.update', 'uses' => 'BootnetCrasher\School\Controllers\Api\userController@updateUser']);

// 

Route::get('api/v1/classes-by-professeur-id/{professeurId}', 'BootnetCrasher\School\Controllers\Api\ClasseMatiereProfesseurController@getClassesByProfesseurId');