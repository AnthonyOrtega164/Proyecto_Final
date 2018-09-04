<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});
/**
 * Mascaras para consumir el servicio web mediante RESTful
 */
$router->Post('/inicio_sesion','PersonaController@inicioSesion');
$router->Get('/listar', 'PublicacionController@listar');
$router->Get('/listarUser/{correo_persona}', 'PublicacionController@listarUser');
$router->Post('/registrar','PublicacionController@registrar');
$router->Post('/modificar','PublicacionController@modificar');
$router->Post('/eliminar','PublicacionController@eliminar');
$router->Post('/listarComentario', 'ComentarioController@listar');
$router->Post('/registrarComentario','ComentarioController@registrar');
$router->Post('/eliminarComentario','ComentarioController@eliminar');


