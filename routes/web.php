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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/accounts', 'AccountController@show');
$router->post('/accounts', 'AccountController@create');
$router->put('/accounts/{id}', 'AccountController@update');
$router->delete('/accounts/{id}', 'AccountController@delete');

$router->get('/categories', 'CategoryController@show');
$router->post('/categories', 'CategoryController@create');
$router->put('/categories/{id}', 'CategoryController@update');
$router->delete('/categories/{id}', 'CategoryController@delete');

$router->get('/statements', 'StatementController@show');
$router->post('/statements', 'StatementController@create');
$router->put('/statements/{id}', 'StatementController@update');
$router->delete('/statements/{id}', 'StatementController@delete');

$router->post('/register', 'UserController@register');
$router->get('/login', 'UserController@login');