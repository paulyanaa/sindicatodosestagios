<?php

use Model\FiliadoModel;

require_once __DIR__ . '/../Config/DatabaseHandler.php';
require_once __DIR__ . '/../Model/FiliadoDAO.php';
require_once __DIR__ . '/../Model/FiliadoModel.php';
require_once __DIR__ . '/../Controller/UsuarioController.php';
class FiliadoController{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler();
        $this->oFiliadoDAO = new FiliadoDAO();
        $this->oUsuarioController = new UsuarioController();

    }
    public function listar()
    {
        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        $sLogin = $oSessao->getDado('login');

        $aFiliados= $this->oFiliadoDAO->findAll();

        if($this->oUsuarioController->isAdmin($sLogin)){
            $bAparecerBotao = true;
        }else {
            $bAparecerBotao = false;
        }

        include('lista-filiados-view.php');
        require_once __DIR__.'/../View/lista-filiados-view.php';
    }

    public function cadastrar(){
        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        if($this->oUsuarioController->isAdmin($oSessao->getDado('login'))){
            require_once  __DIR__.'/../View/cadastrar-filiado-view.php';
        }else{
            echo "<script>alert('Você não tem permissão para fazer cadastro');</script>";
            $this->listar();
        }
    }

    public function deletar(array $aDados = null){
        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        if($this->oUsuarioController->isAdmin($oSessao->getDado('login'))){
            $this->oFiliadoDAO->delete($aDados['id']);

            $this->listar();
        }else{
            require_once  __DIR__.'/../View/login-view.php';
        }
    }

    public function cadastrarFiliado(array $aDados = null){
        $oSessao = new SessaoHandler();
        $oSessao->verificarSessao();

        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->oUsuarioController->isAdmin($oSessao->getDado('login')))){

            $oFiliado = FiliadoModel::createFromArray($aDados);


            if(!$this->oFiliadoDAO->isFiliadoExiste($oFiliado->getSCpf())){
                $this->oFiliadoDAO->save($oFiliado);

                $this->listar();
            }else{
                echo "<script>alert('Filiado já cadastrado. Tente novamente.')";
                $this->listar();
            }
        }
    }


}