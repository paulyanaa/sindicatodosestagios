<?php
namespace Moobi\SindicatoDosEstagios\Model\Dependente;

use DateMalformedStringException;
use Moobi\SindicatoDosEstagios\Handler\DatabaseHandler;

/**
 * Class DependenteDAO
 * @package Moobi\SindicatoDosEstagios\Model\Dependente
 * @version 1.0.0
 */
class DependenteDAO {
	private DatabaseHandler $oDatabase;

	public function __construct() {
		$this->oDatabase = new DatabaseHandler();
	}

	/**
	 * Salva os dados do dependente no banco de dados.
	 *
	 * @param DependenteModel $oDependente
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function save(DependenteModel $oDependente): void {
		$sSql = "INSERT INTO dpe_dependente (flo_id, dpe_nome, dpe_data_nascimento, dpe_grau_de_parentesco) VALUES (?, ?, ?,?)";
		$aParametros = [
			$oDependente->getIdFiliadoAssociado(),
			$oDependente->getNome(),
			$oDependente->getDataNascimento()->format('Y-m-d'),
			$oDependente->getGrauDeParentesco()
		];
		$this->oDatabase->execute($sSql, $aParametros);

		$sSql2 = "UPDATE flo_filiado SET flo_ultima_atualizacao = CURDATE() WHERE flo_filiado.flo_id = ?";
		$aParametros2 = [
			$oDependente->getIdFiliadoAssociado()
		];
		$this->oDatabase->execute($sSql2, $aParametros2);
	}

	/**
	 * Busca os dependentes de determinado filiado.
	 *
	 * @param int $iIdFiliado
	 * @return array
	 *
	 * @throws DateMalformedStringException
	 * @since 1.0.0
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 */
	public function findAllByFiliadoId(int $iIdFiliado): array {
		$sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ?";
		$aParametros = [$iIdFiliado];
		$aDependentes = $this->oDatabase->query($sSql, $aParametros);

		return array_map(function ($aDependente) {
			return DependenteModel::createFromArray($aDependente);
		}, $aDependentes);
	}

	/**
	 * Busca um dependente específico de determinado filiado.
	 *
	 * @param int $iIdFiliado
	 * @param int $iIdDependente
	 * @return DependenteModel
	 *
	 * @throws DateMalformedStringException
	 * @since 1.0.0
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 */
	public function findByIdDependenteEIdFiliado(int $iIdFiliado, int $iIdDependente): DependenteModel {
		$sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ? AND dpe_id = ?";
		$aParametros = [
			$iIdFiliado,
			$iIdDependente
		];
		$oDependente = $this->oDatabase->query($sSql, $aParametros);
		return DependenteModel::createFromArray($oDependente[0]);
	}

	/**
	 * Exclui os dados de determinado dependente do banco de dados.
	 *
	 * @param int $iIdDependente
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function delete(int $iIdDependente): void {
		$sSql = "DELETE FROM dpe_dependente WHERE dpe_id = ?";
		$aParametros = [$iIdDependente];
		$this->oDatabase->execute($sSql, $aParametros);
	}

	/**
	 * Verifica se determinado dependente já está cadastrado no banco de dados.
	 *
	 * @param DependenteModel $oDependente
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function isDependenteExiste(DependenteModel $oDependente): bool {
		$sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ? AND dpe_nome = ? AND dpe_grau_de_parentesco = ?";
		$aParametros = [
			$oDependente->getIdFiliadoAssociado(),
			$oDependente->getNome(),
			$oDependente->getGrauDeParentesco(),
		];
		$aDependentes = $this->oDatabase->query($sSql, $aParametros);
		return !empty($aDependentes);
	}

	/**
	 * Atualiza os dados de determinado dependente no banco de dados.
	 *
	 * @param DependenteModel $oDependente
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * 2since 1.0.0
	 */
	public function update(DependenteModel $oDependente): void {
		$sSql = "UPDATE dpe_dependente SET dpe_nome = ? WHERE dpe_dependente.flo_id = ? and dpe_dependente.dpe_id = ?";
		$aParametros = [
			$oDependente->getNome(),
			$oDependente->getIdFiliadoAssociado(),
			$oDependente->getId()
		];
		$this->oDatabase->execute($sSql, $aParametros);

		$sSql2 = "UPDATE flo_filiado SET flo_ultima_atualizacao = CURDATE() WHERE flo_filiado.flo_id = ?";
		$aParametros2 = [$oDependente->getIdFiliadoAssociado()];
		$this->oDatabase->execute($sSql2, $aParametros2);
	}
}