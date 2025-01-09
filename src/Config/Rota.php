<?php
namespace Moobi\SindicatoDosEstagios\Config;

use Exception;

/**
* Class Rota
* @package Moobi\SindicatoDosEstagios\Config
* @version 1.0.0
*/
class Rota{
	/**
	 * Gerencia e direciona as requisições.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public static function rotear(?array $aDados = null): void {
		$sUrl = strip_tags(filter_input(INPUT_GET, 'url', FILTER_DEFAULT));

		$sVerificacao = (!empty($sUrl)) ? $sUrl : 'usuario/index';

		$sUrl = array_filter(explode('/', $sVerificacao));

		$sController = "Moobi\SindicatoDosEstagios\Controller\\" . ucfirst($sUrl[0]) . 'Controller';
		$sMetodo = $sUrl[1];

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
	}
}

