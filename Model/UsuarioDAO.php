<?php
use Model\UsuarioModel;
require_once __DIR__ . '/../Config/DatabaseHandler.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';

class UsuarioDAO
{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler();
    }

    public function formarObjeto($aDadosUsuario):UsuarioModel
    {
        $oUsuarioModel = new UsuarioModel(
            $aDadosUsuario['uso_id'],
            $aDadosUsuario['uso_login'],
            $aDadosUsuario['uso_senha'],
            $aDadosUsuario['uso_tipo']);

        return $oUsuarioModel;
    }

    public function isUsuarioExiste($sLogin):bool{
        $SSql =" SELECT COUNT(*) AS total FROM uso_usuario WHERE uso_login = ? ";
        $sParametro = [1 => $sLogin];
        $aResultadoConsulta = $this->oDatabase->query($SSql, $sParametro);
        if($aResultadoConsulta[0]["total"] == 1){
            return true;
        } else{
            return false;
        }
    }

    public function save(UsuarioModel $oUsuario, string $sSenhaCriptografada){
        $sSql = "INSERT INTO uso_usuario (uso_login, uso_senha, uso_tipo) VALUES (?, ?, ?)";
        $sParametros = [
            1 => $oUsuario->getSLogin(),
            2 => $sSenhaCriptografada,
            3 => $oUsuario->getSTipo()
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function delete(int $iId){
        $sSql = "DELETE FROM uso_usuario WHERE `uso_usuario`.`uso_id` = ?";
        $sParametros = [
            1 => $iId,
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }



    public function findAll():array{
        $sSql = "SELECT * FROM uso_usuario";
        $aUsuarios = $this->oDatabase->query($sSql);

        $aObjUsuario = array_map(function($usuario){
            return $this->formarObjeto($usuario);
        }, $aUsuarios);

        return $aObjUsuario;
    }



    public function FindByTipo($sTipo):array{
        $sSql = " SELECT * FROM uso_usuario WHERE uso_tipo = ? ";
        $sParametro = [1 => $sTipo];
        $aUsuarios = $this->oDatabase->query($sSql, $sParametro);

        $aObjUsuario = array_map(function($usuario){
            return $this->formarObjeto($usuario);
        }, $aUsuarios);

        if($aObjUsuario!=[]){
            return $aObjUsuario;
        }else{
            return [];
        }
    }

    public function FindByLogin($sLogin):array{
        $sSql = " SELECT * FROM uso_usuario WHERE uso_login = ? ";
        $sParametro = [1 => $sLogin];
        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
        if($aResultadoConsulta!=[]){
            return $aResultadoConsulta[0];
        }else{
            return [];
        }
    }

    public function idFindByLogin($sLogin):array{
        $sSql = " SELECT uso_id FROM uso_usuario WHERE uso_login = ? ";
        $sParametro = [1 => $sLogin];
        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
        return $aResultadoConsulta;
    }

    public function senhaFindByLogin($sLogin){
        $sSql = " SELECT uso_senha FROM uso_usuario WHERE uso_login = ? ";
        $sParametro = [1 => $sLogin];
        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
        if($aResultadoConsulta!=[]){
            return $aResultadoConsulta[0]['uso_senha'];
        }else{
            return [];
        }
    }


}