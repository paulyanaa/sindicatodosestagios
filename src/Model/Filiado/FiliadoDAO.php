<?php
namespace Moobi\SindicatoDosEstagios\Model\Filiado;

use Moobi\SindicatoDosEstagios\Handler\DatabaseHandler;

/**
 * Class FiliadoDAO
 * @package Moobi\SindicatoDosEstagios\Model\Filiado
 * @version 1.0.0
 */
class FiliadoDAO {
	private DatabaseHandler $oDatabase;

	public function __construct() {
		$this->oDatabase = new DatabaseHandler();
	}

	/**
	 * Salva os dados do filiado no banco de dados.
	 *
	 * @param FiliadoModel $oFiliado
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function save(FiliadoModel $oFiliado): void {
		$sSql = "INSERT INTO flo_filiado (
                         flo_nome, 
                         flo_cpf, 
                         flo_rg, 
                         flo_data_nascimento, 
                         flo_empresa, 
                         flo_cargo, 
                         flo_situacao, 
                         flo_tel_residencial, 
                         flo_tel_celular, 
                         flo_ultima_atualizacao
                         ) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
		$aParametros = [
			$oFiliado->getSNome(),
			$oFiliado->getSCpf(),
			$oFiliado->getSRg(),
			$oFiliado->getSDataNascimento()->format('Y-m-d'),
			$oFiliado->getSEmpresa(),
			$oFiliado->getSCargo(),
			$oFiliado->getSSituacao(),
			$oFiliado->getSTelResidencial(),
			$oFiliado->getSTelCelular()
		];
		$this->oDatabase->execute($sSql, $aParametros);
	}

	/**
	 * Exclui os dados de determinado filiado do banco de dados.
	 *
	 * @param int $iIdFiliado
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function delete(int $iIdFiliado): void {
		$sSql = "DELETE FROM flo_filiado WHERE flo_filiado.flo_id = ?";
		$aParametro = [
			$iIdFiliado,
		];
		$this->oDatabase->execute($sSql, $aParametro);
	}

	/**
	 * Atualiza os dados de determinado filiado no banco de dados.
	 *
	 * @param FiliadoModel $oFiliado
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function update(FiliadoModel $oFiliado): void {
		$sSql = "UPDATE flo_filiado 
				SET flo_empresa = ?, flo_cargo = ?, flo_situacao = ?, flo_ultima_atualizacao = CURDATE() 
				WHERE flo_filiado.flo_id = ?";
		$aParametros = [
			$oFiliado->getSEmpresa(),
			$oFiliado->getSCargo(),
			$oFiliado->getSSituacao(),
			$oFiliado->getIId()
		];
		$this->oDatabase->execute($sSql, $aParametros);
	}

	/**
	 * Verifica se determinado filiado já está cadastrado no banco de dados.
	 *
	 * @param string $sCpf
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function isFiliadoExiste(string $sCpf): bool {
		$sSql = "SELECT 1 FROM flo_filiado WHERE flo_cpf = ? LIMIT 1";
		$aParametro = [$sCpf];
		return !empty($this->oDatabase->query($sSql, $aParametro));
	}

	/**
	 * Busca um filiado específico.
	 *
	 * @param int $iIdFiliado
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function findById(int $iIdFiliado): array {
		$sSql = "SELECT * FROM flo_filiado WHERE flo_id = ?";
		$aParametro = [$iIdFiliado];
		$aResultadoConsulta = $this->oDatabase->query($sSql, $aParametro);
		return $aResultadoConsulta[0];
	}

	/**
	 * Busca os filiados pelos crtérios do filtro.
	 *
	 * @param $iMes
	 * @param $sNome
	 * @param $iInicio
	 * @param $iLimite
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function findByFiltro($iMes, $sNome, $iInicio, $iLimite): array {
		$sSql = "SELECT * FROM flo_filiado WHERE 1=1";
		$aParametro = [];

		if (!empty($sNome)) {
			$sSql .= " AND flo_nome LIKE ?";
			$aParametro[] = "%" . $sNome . "%";
		}
		if (!empty($iMes)) {
			$sSql .= " AND MONTH(flo_data_nascimento) = ?";
			$aParametro[] = intval($iMes);
		}

		$sSql .= " ORDER BY flo_nome LIMIT {$iInicio}, {$iLimite}";

		$loFiliados = $this->oDatabase->query($sSql, $aParametro);

		return array_map(function ($filiado) {
			return FiliadoModel::createFromArray($filiado);
		}, $loFiliados);
	}

	/**
	 * Contabiliza todos os filiados.
	 *
	 * @param $iMes
	 * @param $sNome
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return int
	 *
	 * @since 1.0.0
	 */
	public function countFiliados($iMes, $sNome): int {
		$sSql = "SELECT COUNT(flo_cpf) AS total FROM flo_filiado WHERE 1=1";
		$aParametro = [];

		if (!empty($sNome)) {
			$sSql .= " AND flo_nome LIKE ?";
			$aParametro[] = "%" . $sNome . "%";
		}
		if (!empty($iMes)) {
			$sSql .= " AND MONTH(flo_data_nascimento) = ?";
			$aParametro[] = intval($iMes);
		}

		$aConsulta = $this->oDatabase->query($sSql, $aParametro);
		return $aConsulta[0]['total'];
	}
}