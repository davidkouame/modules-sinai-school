<?php

Route::get('api/v1/noteeleves', 'BootnetCrasher\School\Controllers\Api\NoteEleveController@searchEleves')->name('eleves.search');