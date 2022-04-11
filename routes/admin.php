<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'Auth\LoginController@loginAdmin');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::group(['prefix' => 'me'], function () {
        Route::get('', 'Admin\AdminController@me');
    });

    Route::group(['prefix' => 'players'], function () {
        Route::resource('', 'Admin\PlayerController')->only([
            'index'
        ]);
    });

    Route::group(['prefix' => 'leagues'], function () {
        Route::patch('/{id}/attach', 'Admin\LeagueController@attachNameUk');
        Route::patch('/{id}/dettach', 'Admin\LeagueController@dettachNameUk');
        Route::post('/category/country', 'Admin\LeagueController@byCategory');
        Route::post('/{id}/sync', 'Admin\LeagueController@sync');
        Route::post('/sync48', 'Admin\LeagueController@syncLeagues48');
        Route::resource('', 'Admin\LeagueController')->except([
            'create', 'edit'
        ]);
        Route::put('/{id}', 'Admin\LeagueController@update');
    });

    Route::group(['prefix' => 'countries'], function () {
        Route::resource('', 'Admin\CountryController')->only([
            'index'
        ]);
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::resource('', 'Admin\CategoryController')->except([
            'create', 'edit'
        ]);
        Route::put('/{id}', 'Admin\CategoryController@update');
    });

    Route::group(['prefix' => 'bet-types'], function () {
        Route::resource('', 'Admin\BetTypeController')->except([
            'create', 'edit'
        ]);
        Route::put('/{id}', 'Admin\BetTypeController@update');
    });

    Route::group(['prefix' => 'match-structures'], function () {
        Route::resource('', 'Admin\MatchStructureController')->except([
            'create', 'edit'
        ]);
        Route::put('/{id}', 'Admin\MatchStructureController@update');
    });

    Route::group(['prefix' => 'banks'], function () {
        Route::resource('', 'Admin\BankController')->except([
            'create', 'edit'
        ]);
        Route::put('/{id}', 'Admin\BankController@update');
    });

    Route::group(['prefix' => 'accounts'], function () {
        Route::resource('', 'Admin\AccountController')->except([
            'create', 'edit'
        ]);
        Route::put('/{id}', 'Admin\AccountController@update');
    });
});
