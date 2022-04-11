<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// AUTH
Route::group(['prefix' => 'auth'], function () {
    // LOGIN
    Route::post('/login', 'Auth\LoginController@login');
});
