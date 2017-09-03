<?php

use App\Config\Config;

$app->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($app) {

    // COUNTRIES
    $app->get('countries', function () use ($app) {
        $countries = app('db')->select('SELECT id,name FROM countries');
        return $countries;
    });

    // CATEGORIES
    $app->get('cats', function () use ($app) {
        $cats = app('db')->select('SELECT id,name FROM cats');
        return [['name' => Config::MAIN_CAT, 'cats' => $cats]];
    });

    // PROJECTS
    $app->group(['prefix' => 'project'], function () use ($app) {
        $app->get('/', 'ProjectController@index');
        $app->post('/', 'ProjectController@save');
    });
});