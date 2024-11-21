<?php

spl_autoload_register(function ($sClasse) {

    $sArquivo = __DIR__ . "/Controller/$sClasse.php";
    var_dump($sArquivo);
    if(file_exists($sArquivo)){
        require_once $sArquivo;
    } else {
        throw new Exception("Classe '$sClasse' não encontrada.");
    }
});