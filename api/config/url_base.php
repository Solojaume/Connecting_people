<?php 
global $base_imagenes;
global $base_api;
global $base_frontend;
global $base_socket_io;
global $base_socket_io_host;
global $base_socket_io_port;
$GLOBALS['base_imagenes'] = "http://localhost/connectingpeople/api/imagenes/";
$GLOBALS["base_api"] = "http://localhost/connectingpeople/api/web/";
$GLOBALS["base_frontend"] = "http://localhost:4200";
$GLOBALS["base_socket_io"] = ["host"=>$GLOBALS["base_socket_io_host"],"port"=>$GLOBALS["base_socket_io_port"]];
$GLOBALS["base_socket_io_host"] = "127.0.0.1";
$GLOBALS["base_socket_io_port"] = 3000;