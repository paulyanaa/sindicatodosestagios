<?php

use Model\UsuarioModel;

require_once __DIR__ . "/../Config/DatabaseHandler.php";
require_once __DIR__ . '/../Config/PostHandler.php';
require_once __DIR__ . '/../Config/SessaoHandler.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/../Model/UsuarioDAO.php';



class UsuarioController{
    public function __construct()
    {
        $this->oUsuarioDAO = new UsuarioDAO();
        $this->oDatabase = new DatabaseHandler();
        $this->oPost = new PostHandler();
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

//    public function salvarUsuario($sLogin, $sSenha, $sTipo){
//
//        if(!$this->oUsuarioDAO->isUsuarioExiste($sLogin)){
//            $sSenhaCriptografada = password_hash($sSenha, PASSWORD_DEFAULT);
//            $this->oUsuarioDAO->save($sLogin, $sSenhaCriptografada, $sTipo);
//            header('Location: lista-usuarios-view.php');
//        }else{
//            echo "<script>alert('Login já cadastrado. Tente novamente.');</script>";
//        }
//    }



    public function listar()
    {
        $aUsuariosAdmins = $this->oUsuarioDAO->FindByTipo('administrador');
        $aUsuariosComuns = $this->oUsuarioDAO->FindByTipo('comum');

        include('lista-usuarios-view.php');
        require_once __DIR__.'/../View/lista-usuarios-view.php';
    }

    public function menu(){

        echo "entrou menu";
        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        $sLogin = $oSessao->getDado('login');

        $tipo = ($this->oUsuarioDAO->findByLogin($sLogin))['uso_tipo'];

        if($tipo == "administrador"){
            require_once  __DIR__.'/../View/usuario-admin-view.php';
            exit();
        }elseif ($tipo == "comum") {
            require_once  __DIR__.'/../View/usuario-comum-view.php';
            exit();
        }
    }

    public function acessar()
    {
        if ($this->oPost->verificarOcorrencia()) {

            $sLogin = $this->oPost->getDado('login');
            $sSenha = $this->oPost->getDado('senha');

            if ($this->validarSenha($sLogin, $sSenha)){

                $oSessao = new SessaoHandler();

                $oSessao->setDado('login', $sLogin);
                $this->menu();
            } else {
                echo "<script>alert('Usuário ou senha incorretos!');</script>";
            }
        }
    }

    public function cadastrarUsuario(){

        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        $sUsuarioLogado = $oSessao->getDado('login');

        if(($this->oPost->verificarOcorrencia()) && ($this->isAdmin($sUsuarioLogado))){

            $sLogin =  $this->oPost->getDado('login');
            $sSenha =  $this->oPost->getDado('senha');
            $sTipo=  $this->oPost->getDado('tipo');

            if(!$this->oUsuarioDAO->isUsuarioExiste($sLogin)){
                $sSenhaCriptografada = password_hash($sSenha, PASSWORD_DEFAULT);
                $this->oUsuarioDAO->save($sLogin, $sSenhaCriptografada, $sTipo);

                $this->listar();
            }else{
                echo "<script>alert('Login já cadastrado. Tente novamente.');</script>";
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



