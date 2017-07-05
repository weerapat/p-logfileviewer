<?php

Route::get('/', 'LogFileViewerController@index');
Route::get('/get-log-file-data', 'LogFileViewerController@getLogFileData');
