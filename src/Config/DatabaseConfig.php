<?php

namespace Moobi\SindicatoDosEstagios\Config;
class DatabaseConfig
{
	public static function getConexao()
	{
		$sArquivoJson = __DIR__ . '/../Config/dadosDB.json';
		$rJsonData = file_get_contents($sArquivoJson);

		if (empty($rJsonData)) {
			die('Erro ao ler o arquivo JSON.');
		}

		$aDadosBD = json_decode($rJsonData, true);

		if ($aDadosBD === null) {
			die('Erro ao decodificar o JSON.');
		}
		return $aDadosBD;
	}
}