<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $file = '/var/log/install.log';
    $data = file($file);
    $logData = array_slice($data, 0, 10);

    return view('log-viewer', ['logData' => $logData]);
});
