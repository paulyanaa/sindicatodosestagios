<?php
namespace Moobi\SindicatoDosEstagios\Model\Dependente;

use Moobi\SindicatoDosEstagios\Handler\DatabaseHandler;
class DependenteDAO
{
	public function __construct()
	{
		$this->oDatabase = new DatabaseHandler();
	}

	public function save(DependenteModel $oDependente): void
	{
		$sSql = "INSERT INTO dpe_dependente (flo_id, dpe_nome, dpe_data_nascimento, dpe_grau_de_parentesco) VALUES (?, ?, ?,?)";
		$aParametros = [
			$oDependente->getIIdFiliadoAssociado(),
			$oDependente->getSNome(),
			$oDependente->getTDataNascimentoBanco(),
			$oDependente->getSGrauDeParentesco()
		];
		$this->oDatabase->execute($sSql, $aParametros);

		$sSql2 = "UPDATE flo_filiado SET flo_ultima_atualizacao = CURDATE() WHERE flo_filiado.flo_id = ?";
		$aParametros2 = [
			$oDependente->getIIdFiliadoAssociado()
		];
		$this->oDatabase->execute($sSql2, $aParametros2);
	}

	public function findAll(int $iIdFiliado): array
	{
		$sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ?";
		$aParametros = [$iIdFiliado];
		$aDependentes = $this->oDatabase->query($sSql, $aParametros);

		return array_map(function ($aDependente) {
			return DependenteModel::createFromArray($aDependente);
		}, $aDependentes);
	}

	public function findById(int $iIdFiliado, int $iIdDependente): DependenteModel
	{
		$sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ? AND dpe_id = ?";
		$aParametros = [
			$iIdFiliado,
			$iIdDependente
		];
		$oDependente = $this->oDatabase->query($sSql, $aParametros);
		return DependenteModel::createFromArray($oDependente[0]);
	}

	public function delete(int $iIdDependente): void
	{
		$sSql = "DELETE FROM dpe_dependente WHERE dpe_id = ?";
		$aParametros = [$iIdDependente];
		$this->oDatabase->execute($sSql, $aParametros);
	}

	public function deleteAllByFiliado(int $iIdFiliado): void
	{
		$sSql = "DELETE FROM dpe_dependente WHERE flo_id = ?";
		$aParametros = [$iIdFiliado];
		$this->oDatabase->execute($sSql, $aParametros);
	}

	public function isDependenteExiste(DependenteModel $oDependente): bool
	{
		$sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ? AND dpe_nome = ? AND dpe_grau_de_parentesco = ?";
		$aParametros = [
			$oDependente->getIIdFiliadoAssociado(),
			$oDependente->getSNome(),
			$oDependente->getSGrauDeParentesco(),
		];
		$aDependentes = $this->oDatabase->query($sSql, $aParametros);
		return !empty($aDependentes);
	}

	public function update(DependenteModel $oDependente): void
	{
		$sSql = "UPDATE dpe_dependente SET dpe_nome = ? WHERE dpe_dependente.flo_id = ? and dpe_dependente.dpe_id = ?";
		$aParametros = [
			$oDependente->getSNome(),
			$oDependente->getIIdFiliadoAssociado(),
			$oDependente->getIId()
		];
		$this->oDatabase->execute($sSql, $aParametros);

		$sSql2 = "UPDATE flo_filiado SET flo_ultima_atualizacao = CURDATE() WHERE flo_filiado.flo_id = ?";
		$aParametros2 = [$oDependente->getIIdFiliadoAssociado()];
		$this->oDatabase->execute($sSql2, $aParametros2);
	}
}