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

$router->get('/statements', 'StatementController@showAllStatements');
$router->get('/statements/{id}', 'StatementController@showOneStatement');
$router->post('/statements', 'StatementController@create');
$router->put('/statements/{id}', 'StatementController@update');
$router->delete('/statements/{id}', 'StatementController@delete');

$router->post('/register', 'UserController@register');
$router->get('/login', 'UserController@login');
$router->get('/resetToken/{id}', 'UserController@resetToken');