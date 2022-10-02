<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    // AUTH
    Route::group(['prefix' => 'auth'], function () {
        // LOGIN
        Route::post('/login', 'Auth\LoginController@login');
    });

    // CATEGORIES
    Route::get('/categories', 'Api\CategoryController@index');

    // LEAGUES
    Route::get('/leagues/by-name-id/{nameId}', 'Api\LeagueController@indexByNameId');
    Route::get('/leagues/by-category-id/{nameId}', 'Api\LeagueController@indexByCategoryId');

    // GAMES
    Route::get('/games/by-league-id/{leagueId}', 'Api\GameController@indexByLeagueId');
});

