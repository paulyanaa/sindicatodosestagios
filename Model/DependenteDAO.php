<?php

use Model\DependenteModel;

require_once __DIR__ . '/../Config/DatabaseHandler.php';
require_once __DIR__ . '/../Model/DependenteModel.php';
class DependenteDAO
{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler();
    }

    public function save(DependenteModel $oDependente):void{
        $sSql = "INSERT INTO dpe_dependente (flo_id, dpe_nome, dpe_data_nascimento, dpe_grau_de_parentesco) VALUES (?, ?, ?,?)";
        $sParametros = [
            1 => $oDependente->getIIdFiliadoAssociado(),
            2 => $oDependente->getSNome(),
            3 => $oDependente->getTDataNascimentoBanco(),
            4 => $oDependente->getSGrauDeParentesco()
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function findAll(int $id):array{

        $sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ?";
        $sParametros = [
            1 => $id
        ];
        $aDependentes = $this->oDatabase->query($sSql, $sParametros);
        $aObjDependente = array_map(function($dependente){
            return DependenteModel::createFromArray($dependente);
        }, $aDependentes);

        return $aObjDependente;
    }

    public function findById(int $idFiliado, int $idDependente):DependenteModel{

        $sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ? AND dpe_id = ?";
        $sParametros = [
            1 => $idFiliado,
            2 => $idDependente
        ];
        $oDependente = $this->oDatabase->query($sSql, $sParametros);

        return DependenteModel::createFromArray($oDependente[0]);
    }

    public function delete(int $dpe_id)
    {
        $sSql = "DELETE FROM dpe_dependente WHERE dpe_id = ?";
        $sParametros = [
            1 => $dpe_id
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function deleteAllByFiliado(int $idFiliado)
    {
        $sSql = "DELETE FROM dpe_dependente WHERE flo_id = ?";
        $sParametros = [
            1 => $idFiliado
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function isDependenteExiste(DependenteModel $oDependente):bool{
        $sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ? AND dpe_nome = ? AND dpe_grau_de_parentesco = ?";
        $sParametros = [
            1 => $oDependente->getIIdFiliadoAssociado(),
            2 => $oDependente->getSNome(),
            3 => $oDependente->getSGrauDeParentesco(),
        ];
        $aDependentes = $this->oDatabase->query($sSql, $sParametros);
        return !empty($aDependentes);

    }

    public function update(DependenteModel $oDependente)
    {
        $sSql = "UPDATE dpe_dependente SET dpe_nome = ? WHERE dpe_dependente.flo_id = ? and dpe_dependente.dpe_id = ?";
        $sParametros = [
            1 => $oDependente->getSNome(),
            2 => $oDependente->getIIdFiliadoAssociado(),
            3 => $oDependente->getIId()
        ];
        $this->oDatabase->execute($sSql, $sParametros);

        $sSql2 = "UPDATE flo_filiado SET flo_ultima_atualizacao = CURDATE() WHERE flo_filiado.flo_id = ?";
        $sParametros2 = [
            1 => $oDependente->getIIdFiliadoAssociado()
        ];
        $this->oDatabase->execute($sSql2, $sParametros2);
    }

}