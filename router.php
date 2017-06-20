<?php

session_start();

$routes = require 'configs/routes.php';
$default_route = $routes[ 'default' ];
$route_parts = explode( '/', $default_route );
$method = $_SERVER[ 'REQUEST_METHOD' ];

$ressource = $_REQUEST[ 'ressource' ] ?? $route_parts[ 1 ];
$action = $_REQUEST[ 'action' ] ?? $route_parts[ 2 ];

if ( !in_array( $method . '/' . $ressource . '/' . $action, $routes ) ) {
    $view = 'views/404.php';
    $page_title = 'Page introuvable';
    $page_description = 'Error page from Ex Libris, online library';
    $data = compact( 'view', 'page_title', 'page-description' );
    die( 'Unauthorized action ' . $action . ' on ressource ' . $ressource . ' with method ' . $method . '.' );
}

$controllerName = 'Controllers\\' . ucfirst( $ressource );

$controller = new $controllerName();
$data = call_user_func( [ $controller, $action ] );
