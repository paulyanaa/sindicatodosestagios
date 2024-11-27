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

    public function save(DependenteModel $oDependente){
        $sSql = "INSERT INTO dpe_dependente (flo_id, dpe_nome, dpe_data_nascimento, dpe_grau_de_parentesco) VALUES (?, ?, ?,?)";
        $sParametros = [
            1 => $oDependente->getIIdFiliadoAssociado(),
            2 => $oDependente->getSNome(),
            3 => $oDependente->getTDataNascimento(),
            4 => $oDependente->getSGrauDeParentesco()
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function findById(int $id):array{
        $sSql = "SELECT * FROM dpe_dependente WHERE flo_id = ?";
        $sParametros = [
            1 => $id
        ];

        $aDependentes = $this->oDatabase->query($sSql, $sParametros);
        var_dump($aDependentes);
        $aObjDependente[] = array_map(function($dependente){
            return DependenteModel::createFromArray($dependente);
        }, $aDependentes);

        return $aObjDependente;
    }

}