<?php

use App\Config\Config;

$router->group(['prefix' => 'api', 'middleware' => 'auth'], function () use ($router) {

    // COUNTRIES
    $router->get('countries', function () use ($router) {
        $countries = app('db')->select('SELECT id,name FROM countries');
        return $countries;
    });

    // CATEGORIES
    $router->get('cats', function () use ($router) {
        $cats = app('db')->select('SELECT id,name FROM cats');
        return [['name' => Config::MAIN_CAT, 'cats' => $cats]];
    });

    // PROJECTS
    $router->group(['prefix' => 'project'], function () use ($router) {
        $router->get('/', 'ProjectController@index');
        $router->get('/{id}', 'ProjectController@getOne');
        $router->post('/', 'ProjectController@save');
        $router->delete('/{id}', 'ProjectController@remove');
    });

    // PROJECT APPLICATIONS
    $router->group(['prefix' => 'project/apply'], function () use ($router) {
        $router->post('/{id}', 'ApplicationController@studentApply');
        $router->delete('/cancel/{id}', 'ApplicationController@studentApplyCancel');
    });
});