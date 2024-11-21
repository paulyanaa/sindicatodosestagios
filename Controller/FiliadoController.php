<?php

use Model\FiliadoModel;

require_once __DIR__ . '/../Config/DatabaseHandler.php';
require_once __DIR__ . '/../Model/FiliadoDAO.php';
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
        $aFiliados= $this->oFiliadoDAO->findAll();

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
            require_once  __DIR__.'/../View/lista-filiados-view.php';
        }
    }


}