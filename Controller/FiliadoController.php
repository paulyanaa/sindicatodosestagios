<?php

use Model\FiliadoModel;
use Utils\Functions;

require_once __DIR__ . '/../Model/FiliadoDAO.php';
require_once __DIR__ . '/../Model/FiliadoModel.php';
//require_once __DIR__ . '/../Utils/Functions.php';
require_once __DIR__ . '/../Controller/UsuarioController.php';

class FiliadoController{
    public function __construct()
    {
        $this->oFiliadoDAO = new FiliadoDAO();
        $this->oUsuarioController = new UsuarioController();
        $this->oSessao = new SessaoHandler();

        $this->oSessao->verificarSessao();
        $this->sLogin = $this->oSessao->getDado('login');

    }
    public function listar():void
    {
        $aFiliados= $this->oFiliadoDAO->findAll();

        foreach($aFiliados as $aFiliado){

            $sEmpresa = $aFiliado->getSEmpresa() == null
                ? '-'
                : $aFiliado->getSEmpresa();
            $aFiliado->setSEmpresa($sEmpresa);

            $sCargo = $aFiliado->getSCargo() == null
                ? '-'
                : $aFiliado->getSCargo();
            $aFiliado->setSCargo($sCargo);
        }

        if($this->oUsuarioController->isAdmin($this->sLogin)){
            $bAparecerBotao = true;
        }else {
            $bAparecerBotao = false;
        }

        include('lista-filiados-view.php');
        require_once __DIR__.'/../View/lista-filiados-view.php';
    }


    public function cadastrar():void{
        if($this->oUsuarioController->isAdmin($this->sLogin)){
            require_once  __DIR__.'/../View/cadastrar-filiado-view.php';
        }else{
            echo "<script>alert('Você não tem permissão para fazer cadastro de filiado');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }

    public function deletar(?array $aDados = null):void{

        if($this->oUsuarioController->isAdmin($this->sLogin)){
            $this->oFiliadoDAO->delete($aDados['id']);

            $this->listar();
        }else{
            echo "<script>alert('Você não tem permissão para deletar um filiado');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }

    public function editar(?array $aDados = null):void{

        if($this->oUsuarioController->isAdmin($this->sLogin)){
            $oFiliado = FiliadoModel::createFromArray($this->oFiliadoDAO->findById($aDados['id']));
            include('editar-filiado-view.php');
            require_once  __DIR__.'/../View/editar-filiado-view.php';
        }else{
            echo "<script>alert('Você não tem permissão para editar um filiado');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }

    public function cadastrarFiliado(?array $aDados = null):void{

        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->oUsuarioController->isAdmin($this->sLogin))){

            $oFiliado = FiliadoModel::createFromArray($aDados);

            if(!$this->oFiliadoDAO->isFiliadoExiste($oFiliado->getSCpf())){
                $this->oFiliadoDAO->save($oFiliado);

            }else{
                echo "<script>alert('Filiado já cadastrado. Tente novamente.');</script>";
            }
            $this->listar();
        }

    }public function editarFiliado(?array $aDados = null):void{
        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->oUsuarioController->isAdmin($this->sLogin))){
            $oFiliado = FiliadoModel::createFromArray($aDados);
            $this->oFiliadoDAO->update($oFiliado);
            $this->listar();
        }
    }

//    private function validaDados($sNome, $sCpf, $sRg, $tDataNascimento){
//
//        $sCpf = Functions::validarCpf($oFiliado->getSCpf());
//    }


}