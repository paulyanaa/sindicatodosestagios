<?php
require_once "vendor/autoload.php";

$sUrl = strip_tags(filter_input(INPUT_GET, 'url', FILTER_DEFAULT));

$sVerificacao = (!empty($sUrl)) ? $sUrl : 'usuario/index';

$sUrl = array_filter(explode('/', $sVerificacao));

$sController = "Moobi\SindicatoDosEstagios\Controller\\" . ucfirst($sUrl[0]) . 'Controller';
$sMetodo = $sUrl[1];
$aDados = array_merge($_POST, $_GET);

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