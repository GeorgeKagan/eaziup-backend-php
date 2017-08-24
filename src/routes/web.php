<?php

$app->group(['prefix' => 'api'], function () use ($app) {
    $app->get('countries', function () use ($app) {
        $countries = app('db')->select("SELECT * FROM countries");
        return $countries;
    });

    $app->get('cats', function () use ($app) {
        return '[{
    "label": "Software",
  "cats": [{
        "id": 1,
    "label": "Web Application"
  }, {
        "id": 2,
    "label": "Mobile Application"
  }, {
        "id": 3,
    "label": "eCommerce"
  }, {
        "id": 4,
    "label": "WordPress"
  }]
}]';
    });

    $app->post('project', [
        'as' => 'project', 'uses' => 'ProjectController@save'
    ]);
});