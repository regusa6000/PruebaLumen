<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

/*Rutas de Productos*/
$router->get('/productos/{id}','ProductosController@index');
$router->get('/productos','ProductosController@principal');

//Rutas de Login
$router->post('/login','UserAdminController@login');
$router->post('/register','UserAdminController@register');

//Rutas de Errores
$router->get('/errors/{id_product}/{id_image}/{error}/{ok}','ErrorsController@insertError');
$router->get('/errorsVerify/{id_image}','ErrorsController@verify');
$router->get('/resultError','ErrorsController@resultError');
$router->get('/updateError/{id_image}','ErrorsController@updateActiveError');

//Rutas de Oks
$router->get('ok/{id_product}/{id_image}/{error}/{ok}','OkController.php@insertOk');
$router->get('/resultOk','OkController.php@resultOk');
$router->get('/updateOk/{id_image}','OkController.php@updateActiveOk');
