<?php

use Model\UsuarioModel;

require_once '../Config/DatabaseHandler.php';
require_once '../Config/PostHandler.php';
require_once '../Config/SessaoHandler.php';
require_once '../Model/UsuarioModel.php';



class UsuarioController{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler("localhost", 'root', 'password','3306', 'paulyana');
        $this->oPost = new PostHandler();


    }

    public function formarObjeto($aDadosUsuario):UsuarioModel{

        $oUsuarioModel = new UsuarioModel(
            $aDadosUsuario['uso_id'],
            $aDadosUsuario['uso_login'],
            $aDadosUsuario['uso_senha'],
            $aDadosUsuario['uso_tipo']);

        return $oUsuarioModel;
    }

    public function findAll():array{
        $sSql = "SELECT * FROM uso_usuario";
        $aUsuarios = $this->oDatabase->query($sSql);

        $aObjUsuario = array_map(function($usuario){
            return $this->formarObjeto($usuario);
        }, $aUsuarios);

        return $aObjUsuario;
    }

//    public function save(UsuarioModel $oUsuarioModel){
//        $sSenhaCriptografada = password_hash($oUsuarioModel->getSSenha(), PASSWORD_DEFAULT);
//        $sSql = "INSERT INTO uso_usuario (uso_login, uso_senha, uso_tipo) VALUES (?, ?, ?)";
//        $sParametros = [
//            1 => $oUsuarioModel->getLogin(),
//            2 => $sSenhaCriptografada,
//            3 => $oUsuarioModel->getTipo()
//        ];
//        return $this->oDatabase->execute($sSql, $sParametros);
//    }

    public function save($sLogin, $sSenha, $sTipo){

        if(!$this->isUsuarioExiste($sLogin)){
            $sSenhaCriptografada = password_hash($sSenha, PASSWORD_DEFAULT);
            $sSql = "INSERT INTO uso_usuario (uso_login, uso_senha, uso_tipo) VALUES (?, ?, ?)";
            $sParametros = [
                1 => $sLogin,
                2 => $sSenhaCriptografada,
                3 => $sTipo
            ];
            $this->oDatabase->execute($sSql, $sParametros);
            header('Location: lista-usuarios-view.php');
        }else{
            echo "<script>alert('Login já cadastrado. Tente novamente.');</script>";
        }


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

    public function validarSenha($sLogin, $sSenha):bool{
        if ($this->isUsuarioExiste($sLogin)){
            return password_verify($sSenha,$this->senhaFindByLogin($sLogin));
        } else {
            return false;
        }
    }

    public function verificarTipo($sLogin){
        $tipo = ($this->findByLogin($sLogin))['uso_tipo'];

        if($tipo == "administrador"){
            header('Location: usuario-admin-view.php');
            exit();
        }elseif ($tipo == "comum") {
            header('Location: usuario-comum-view.php');
            exit();
        }
    }

    public function isAdmin($sLogin){
        $sTipo = ($this->findByLogin($sLogin))['uso_tipo'];

        if($sTipo == "administrador"){
            return true;
        }else{
            return false;
        }
    }


    public function acessarSistema()
    {
        if ($this->oPost->verificarOcorrencia()) {

            $oUsuarioController = new UsuarioController();

            $sLogin = $this->oPost->getDado('login');
            $sSenha = $this->oPost->getDado('senha');

            if ($oUsuarioController->validarSenha($sLogin, $sSenha)){

                $oSessao = new SessaoHandler();

                $oSessao->setDado('login', $sLogin);
                $oUsuarioController->verificarTipo($oSessao->getDado('login'));
            } else {
                echo "<script>alert('Usuário ou senha incorretos!');</script>";
            }
        }
    }

    public function deslogarUsuario(){
        $oSessao = new SessaoHandler();
        $oSessao->deslogarSessao();
        header("Location: login-usuario.php");
        exit();
    }


    public function cadastrarUsuario(){

        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        $sUsuarioLogado = $oSessao->getDado('login');

        if(($this->oPost->verificarOcorrencia()) && ($this->isAdmin($sUsuarioLogado))){

            $sLogin =  $this->oPost->getDado('login');
            $sSenha =  $this->oPost->getDado('senha');
            $sTipo=  $this->oPost->getDado('tipo');

            $this->save($sLogin, $sSenha, $sTipo);
        }
    }

}



