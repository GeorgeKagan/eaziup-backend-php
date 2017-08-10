<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/countries', function () use ($app) {
    $countries = app('db')->select("SELECT * FROM countries");
    return $countries;
});

$app->get('/cats', function () use ($app) {
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