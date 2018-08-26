<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/inicio_sesion','PersonaController@inicioSesion');
$router->get('/listar', 'PublicacionController@listar');
$router->get('/listarUser/{correo_persona}', 'PublicacionController@listarUser');
$router->post('/registrar','PublicacionController@registrar');
$router->post('/modificar','PublicacionController@modificar');
$router->post('/eliminar','PublicacionController@eliminar');
$router->post('/listarComentario', 'ComentarioController@listar');
$router->post('/registrarComentario','ComentarioController@registrar');
$router->post('/eliminarComentario','ComentarioController@eliminar');


