<?php

use Model\UsuarioModel;

require_once __DIR__ . "/../Config/DatabaseHandler.php";
require_once __DIR__ . '/../Config/SessaoHandler.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/../Model/UsuarioDAO.php';



class UsuarioController{
    public function __construct()
    {
        $this->oUsuarioDAO = new UsuarioDAO();
        $this->oDatabase = new DatabaseHandler();
    }

    public function index(){
        require_once  __DIR__.'/../View/home-view.php';
    }

    public function login(){
        require_once  __DIR__.'/../View/login-view.php';
    }

    public function logout(){
        $oSessao = new SessaoHandler();
        $oSessao->deslogarSessao();
        require_once  __DIR__.'/../View/home-view.php';
        exit();
    }

    public function cadastrar(){
        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        if($this->isAdmin($oSessao->getDado('login'))){
            require_once  __DIR__.'/../View/cadastrar-usuario-view.php';
        }else{
            require_once  __DIR__.'/../View/login-view.php';
        }
    }

    public function deletar(array $aDados = null){

        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        if($this->isAdmin($oSessao->getDado('login'))){
            $this->oUsuarioDAO->delete($aDados['id']);

            $this->listar();
        }else{
            require_once  __DIR__.'/../View/login-view.php';
        }
    }

    public function listar()
    {
        $aUsuariosAdmins = $this->oUsuarioDAO->FindByTipo('administrador');
        $aUsuariosComuns = $this->oUsuarioDAO->FindByTipo('comum');

        include('lista-usuarios-view.php');
        require_once __DIR__.'/../View/lista-usuarios-view.php';
    }

//    public function menu(){
//
//        $oSessao = new SessaoHandler();
//        $oSessao->verificarSessao();
//
//        $sLogin = $oSessao->getDado('login');
//
//        $tipo = ($this->oUsuarioDAO->findByLogin($sLogin))['uso_tipo'];
//
//        if($tipo == "administrador"){
//            require_once  __DIR__.'/../View/menu-view.php';
//            exit();
//        }elseif ($tipo == "comum") {
//            require_once  __DIR__.'/../View/usuario-cmum-view.php';
//            exit();
//        }
//    }

    public function menu(){

        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        $sLogin = $oSessao->getDado('login');

        //$tipo = ($this->oUsuarioDAO->findByLogin($sLogin))['uso_tipo'];

        if($this->isAdmin($sLogin)){
            $bAparecerBotao = true;
        }else {
            $bAparecerBotao = false;
        }

        include('menu-view.php');
        require_once  __DIR__.'/../View/menu-view.php';
        exit();
    }

    public function acessar(array $aDados = null)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($this->validarSenha($aDados['login'], $aDados['senha'])){

                $oSessao = new SessaoHandler();

                $oSessao->setDado('login', $aDados['login']);
                $this->menu();
            } else {
                echo "<script>alert('Usuário ou senha incorretos!');</script>";
                $this->login();
            }
        }
    }

    public function cadastrarUsuario(array $aDados = null){


        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        $sUsuarioLogado = $oSessao->getDado('login');

        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->isAdmin($sUsuarioLogado))){

            $oUsuario = UsuarioModel::createFromArray($aDados);

            if(!$this->oUsuarioDAO->isUsuarioExiste($oUsuario->getSLogin())){
                $sSenhaCriptografada = password_hash($oUsuario->getSSenha(), PASSWORD_DEFAULT);
                $this->oUsuarioDAO->save($oUsuario, $sSenhaCriptografada);
                $this->listar();
            }else{
                echo "<script>alert('Login já cadastrado. Tente novamente.');</script>";
                $this->listar();
            }
        }
    }

    private function validarSenha($sLogin, $sSenha):bool{
        if ($this->oUsuarioDAO->isUsuarioExiste($sLogin)){
            return password_verify($sSenha,$this->oUsuarioDAO->senhaFindByLogin($sLogin));
        } else {
            return false;
        }
    }

    public function isAdmin($sLogin):bool{
        $sTipo = ($this->oUsuarioDAO->findByLogin($sLogin))['uso_tipo'];
        if($sTipo == "administrador"){
            return true;
        }else{
            return false;
        }
    }

}



