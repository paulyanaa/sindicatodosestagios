<?php

spl_autoload_register(function ($sClasse) {

    $sClasse = str_replace('\\', '/', $sClasse);
    $sArquivo = __DIR__ . "/Controller/$sClasse.php";

    if (file_exists($sArquivo)) {
        require_once $sArquivo;
    } else {
        throw new Exception("Classe '$sClasse' não encontrada. Caminho procurado: $sArquivo");
    }
});
