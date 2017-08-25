<?php

use App\Config\Config;

$app->group(['prefix' => 'api'], function () use ($app) {

    $app->get('countries', function () use ($app) {
        $countries = app('db')->select('SELECT id,name FROM countries');
        return $countries;
    });

    $app->get('cats', function () use ($app) {
        $cats = app('db')->select('SELECT id,name FROM cats');
        return [['name' => Config::MAIN_CAT, 'cats' => $cats]];
    });

    $app->group(['prefix' => 'project'], function () use ($app) {
        $app->get('/', 'ProjectController@index');
        $app->post('/', 'ProjectController@save');
    });
});