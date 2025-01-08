<?php

namespace Moobi\SindicatoDosEstagios\Handler;

use Moobi\SindicatoDosEstagios\Config\DatabaseConfig;
use PDO;
use PDOException;

/**
 * Class DatabaseHandler
 * @package Moobi\SindicatoDosEstagios\Handler
 * @version 1.0.0
 */
class DatabaseHandler
{
	private PDO $oPDO;

	public function __construct()
	{
		$aDadosDB = DatabaseConfig::getConexao();

		try {
			$this->oPDO = new PDO(
				"mysql:host={$aDadosDB['host']};port={$aDadosDB['porta']};dbname={$aDadosDB['dbname']};charset=utf8",
				$aDadosDB['usuario'],
				$aDadosDB['senha']
			);
		} catch (PDOException $e) {
			echo "Erro ao tentar se conectar com o banco: " . $e->getMessage();
		}
	}

	/**
	 *Efetua consultas no banco de dados usando PDO.
	 *
	 * @param $sSql
	 * @param array $aParametros
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return array|false
	 *
	 * @since 1.0.0
	 */
	public function query($sSql, array $aParametros = []): false|array {
		try {
			if (!empty($aParametros)) {
				$PDOStatement = $this->oPDO->prepare($sSql);
				foreach ($aParametros as $sParametro => &$sValor) {
					$PDOStatement->bindValue($sParametro + 1, $sValor);
				}
				$PDOStatement->execute();
			} else {
				$PDOStatement = $this->oPDO->query($sSql);
			}
			return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			echo "Erro na consulta: " . $e->getMessage();
			return false;
		}
	}

	/**
	 * Executa ações no banco de dados utilizando PDO.
	 *
	 * @param $sSql
	 * @param array $aParametros
	 * @return bool
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @since 1.0.0
	 */
	public function execute($sSql, array $aParametros = []): bool {
		try {
			$PDOStatement = $this->oPDO->prepare($sSql);
			foreach ($aParametros as $sParametro => &$sValor) {
				$PDOStatement->bindValue($sParametro + 1, $sValor);
			}
			return $PDOStatement->execute();
		} catch (PDOException $e) {
			echo "Erro na execução: " . $e->getMessage();
			return false;
		}
	}

}
