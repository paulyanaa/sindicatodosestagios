<?php

use Model\FiliadoModel;

require_once __DIR__ . '/../Config/DatabaseHandler.php';
require_once __DIR__ . '/../Model/FiliadoModel.php';
class FiliadoDAO{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler();
    }

    public function formarObjeto($aDadosFiliado):FiliadoModel{

        $oFiliadoModel = new FiliadoModel(
            $aDadosFiliado['flo_id'],
            $aDadosFiliado['flo_nome'],
            $aDadosFiliado['flo_cpf'],
            $aDadosFiliado['flo_rg'],
            new DateTime($aDadosFiliado['flo_data_nascimento']),
            $aDadosFiliado['flo_idade'],
            $aDadosFiliado['flo_empresa'],
            $aDadosFiliado['flo_cargo'],
            $aDadosFiliado['flo_situacao'],
            $aDadosFiliado['flo_tel_residencial'],
            $aDadosFiliado['flo_tel_celular'],
            new DateTime($aDadosFiliado['flo_ultima_atualizacao'])
        );
        return $oFiliadoModel;
    }

    public function save($sLogin, $sSenha, $sTipo){
        $sSql = "INSERT INTO uso_usuario (uso_login, uso_senha, uso_tipo) VALUES (?, ?, ?)";
        $sParametros = [
            1 => $sLogin,
            2 => $sSenha,
            3 => $sTipo
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function findAll():array{
        $sSql = "SELECT * FROM flo_filiado";
        $aFiliados = $this->oDatabase->query($sSql);

        $aObjFiliado = array_map(function($filiado){
            return $this->formarObjeto($filiado);
        }, $aFiliados);

        return $aObjFiliado;
    }

}