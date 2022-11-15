<?php 
global $base_imagenes;
global $base_api;
global $base_frontend;
global $base_socket_io;
global $base_socket_io_host;
global $base_socket_io_port;
$dominio_base="192.168.1.58";
//$dominio_base="localhost";
$GLOBALS['base_imagenes'] = "http://".$dominio_base."/connectingpeople/api/imagenes/";
$GLOBALS["base_api"] = "http://".$dominio_base."/connectingpeople/api/web/";
$GLOBALS["base_frontend"] = "http://".$dominio_base.":4200";
$GLOBALS["base_socket_io"] = ["host"=>$GLOBALS["base_socket_io_host"],"port"=>$GLOBALS["base_socket_io_port"]];
$GLOBALS["base_socket_io_host"] = $dominio_base;
$GLOBALS["base_socket_io_port"] = 3000;