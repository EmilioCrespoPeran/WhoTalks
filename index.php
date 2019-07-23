<?php

// Definicion de constantes para la aplicacion
define("URI", preg_split("#\*\/[a-zA-Z]+#", "*" . $_SERVER["REQUEST_URI"])[1]);
define("SCHEME", $_SERVER['REQUEST_SCHEME']."://");
define("SERVER", SCHEME . $_SERVER['SERVER_NAME']);
define("URL_ROOT", SERVER . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) );
define("PATH_APP", __DIR__);

if($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

// Elimina 'index.php' de la uri
if((strpos($_SERVER["REQUEST_URI"], "index.php") || strpos($_SERVER["REQUEST_URI"], "index.php/")) === true){
    header("Location: ". SERVER . strstr(URI, "index.php", true), true, 301);
    exit();
}

// Recarga la direccion para que añada al final de la uri "/" en
// caso de que el ultimo caracter no sea una "/", para que se vea mejor
if(substr($_SERVER["REQUEST_URI"], -1) != "/") {
    header("Location: ". URL_ROOT . substr(URI, 1) . "/", true, 301);
    exit();
}

// Incluye las clases necesarias para la aplicacion
require PATH_APP . "/controller/ApplicationController.php";
// Este require es para el autocargador de clases de Twig
//require_once PATH_APP."/vendor/autoload.php";

// Inicia el motor de plantillas Twig
/*
$loader = new \Twig\Loader\FilesystemLoader(PATH_APP."/view/");
$twig = new \Twig\Environment($loader, array(
    'cache' => false,
));
// Añade una funcion a Twig llamada 'asset' para localizar el directorio recursos
$twig->addFunction(new \Twig\TwigFunction('asset', function ($asset) {
    return sprintf(URL_ROOT.'resources/%s', ltrim($asset, '/'));
}));
*/
// Inicia una sesion
session_start();

// Inicia la aplicacion
\controller\ApplicationController::getApplicationContext()->init();
