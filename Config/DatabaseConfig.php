<?php


class DatabaseConfig{

    public static function getConeccao(){

        $sArquivoJson = __DIR__ . '/../Config/dadosDB.json';

        $jsonData = file_get_contents($sArquivoJson);


        if (empty($jsonData)) {
        die('Erro ao ler o arquivo JSON.');
        }

        $aDadosBD = json_decode($jsonData, true);

        if ($aDadosBD === null) {
            die('Erro ao decodificar o JSON.');
        }

        return $aDadosBD;
    }
}