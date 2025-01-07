<?php

require_once "vendor/autoload.php";

$url = strip_tags(filter_input(INPUT_GET, 'url', FILTER_DEFAULT));

$verificacao = (!empty($url)) ? $url : 'usuario/index';

$url = array_filter(explode('/', $verificacao));

$sController = "Moobi\SindicatoDosEstagios\Controller\\" . ucfirst($url[0]) . 'Controller';
$sMetodo = $url[1];
$aDados = array_merge($_POST, $_GET);

try {

    if (class_exists($sController)) {
//	    var_dump($sController);
//	    var_dump($sMetodo);

	    $oController = new $sController();
    } else {
        throw new Exception("Controlador '$sController' não encontrado.");
    }


//	var_dump(method_exists($oController, $sMetodo));
//	exit();

    if (method_exists($oController, $sMetodo)) {
        $oController->$sMetodo($aDados);
    } else {
        throw new Exception("Método '$sMetodo' não encontrado.");
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}