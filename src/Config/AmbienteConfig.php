<?php
namespace Moobi\SindicatoDosEstagios\Config;

/**
 * Class AmbienteConfig
 * @package Moobi\SindicatoDosEstagios\Config
 * @version 1.0.0
 */
class AmbienteConfig {
	/**
	 * Cria variável de ambiente.
	 *
	 * @param string $sCaminho
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function getUrl(string $sCaminho): string {
		$sUrlBase = 'http://localhost:80/sindicatodosestagios/';
		return $sUrlBase . $sCaminho;
	}
}

