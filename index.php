<?php


require_once __DIR__ . "/Controller/teste.php";
require_once __DIR__ . "/Controller/UsuarioController.php";
require_once __DIR__ . "/Controller/FiliadoController.php";

$url = strip_tags(filter_input(INPUT_GET, 'url', FILTER_DEFAULT));

$verificacao = (!empty($url)) ? $url : 'usuario/index';

$url = array_filter(explode('/', $verificacao));

$sController = ucfirst($url[0]) . 'Controller';
$sMetodo = $url[1];
$aDados = array_merge($_POST, $_GET);

var_dump($url);
var_dump($sController);
var_dump($sMetodo);


try {
    if (class_exists($sController)) {
        $oController = new $sController();
    } else {
        throw new Exception("Controlador '$sController' não encontrado.");
    }


    if (method_exists($oController, $sMetodo)) {
        $oController->$sMetodo($aDados);
    } else {
        throw new Exception("Método '$sMetodo' não encontrado.");
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}