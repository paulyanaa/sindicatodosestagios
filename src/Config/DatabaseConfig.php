<?php

namespace Moobi\SindicatoDosEstagios\Config;

/**
 * Class DatabaseConfig
 * @package Moobi\SindicatoDosEstagios\Config
 * @version 1.0.0
 */
class DatabaseConfig
{
	/**
	 * Transforma arquivo json com dados do Banco em array
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return mixed|void
	 *
	 * @since 1.0.0
	 */
	public static function getConexao() {
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