<?php
require_once "vendor/autoload.php";

use Moobi\SindicatoDosEstagios\Config\Rota;

$aDados = array_merge($_POST, $_GET);
Rota::rotear($aDados);