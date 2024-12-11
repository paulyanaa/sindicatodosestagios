<?php


use Model\UsuarioModel;

require_once __DIR__ . '/../Handler/DatabaseHandler.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';

class UsuarioDAO
{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler();
    }

    public function isUsuarioExiste($sLogin):bool{
        $SSql ="SELECT 1 FROM uso_usuario WHERE uso_login = ? LIMIT 1";
        $sParametro = [$sLogin];
        $aResultadoConsulta = $this->oDatabase->query($SSql, $sParametro);
        return !empty($aResultadoConsulta);
    }

    public function save(UsuarioModel $oUsuario, string $sSenhaCriptografada):void{

        $sSql = "INSERT INTO uso_usuario (uso_login, uso_senha, uso_tipo) VALUES (?, ?, ?)";
        $sParametros = [
            $oUsuario->getSLogin(),
            $sSenhaCriptografada,
            $oUsuario->getSTipo()
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function delete(int $iId):void{
        $sSql = "DELETE FROM uso_usuario WHERE `uso_usuario`.`uso_id` = ?";
        $sParametros = [
            $iId,
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }


    public function findAll():array{
        $sSql = "SELECT * FROM uso_usuario";
        $aUsuarios = $this->oDatabase->query($sSql);

        $aObjUsuario = array_map(function($usuario){
            return UsuarioModel::createFromArray($usuario);
        }, $aUsuarios);

        return $aObjUsuario;
    }



    public function FindByTipo($sTipo):array{
        $sSql = " SELECT * FROM uso_usuario WHERE uso_tipo = ? ";
        $sParametro = [$sTipo];
        $aUsuarios = $this->oDatabase->query($sSql, $sParametro);

        $aObjUsuario = array_map(function($usuario){
            return UsuarioModel::createFromArray($usuario);
        }, $aUsuarios);

        return $aObjUsuario;
//        if($aObjUsuario!=[]){
//            return $aObjUsuario;
//        }else{
//            return [];
//        }
    }

    public function FindByLogin($sLogin):array{
        $sSql = " SELECT * FROM uso_usuario WHERE uso_login = ? ";
        $sParametro = [$sLogin];
        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
        if($aResultadoConsulta!=[]){
            return $aResultadoConsulta[0];
        }else{
            return [];
        }
    }

//    public function idFindByLogin($sLogin):array{
//        $sSql = " SELECT uso_id FROM uso_usuario WHERE uso_login = ? ";
//        $sParametro = [1 => $sLogin];
//        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
//        return $aResultadoConsulta;
//    }

    public function senhaFindByLogin($sLogin):array{
        $sSql = " SELECT uso_senha FROM uso_usuario WHERE uso_login = ? ";
        $sParametro = [$sLogin];
        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
        if(!empty($aResultadoConsulta)){
            return $aResultadoConsulta[0];
        }else{
            return [];
        }
    }


}