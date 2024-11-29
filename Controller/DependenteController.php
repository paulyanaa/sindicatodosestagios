<?php

use Model\DependenteModel;

require_once __DIR__ . '/../Model/DependenteDAO.php';
require_once __DIR__ . '/../Model/DependenteModel.php';
require_once __DIR__ . '/../Controller/UsuarioController.php';

class DependenteController
{
    public function __construct()
    {
        $this->oUsuarioController = new UsuarioController();
        $this->oDependenteDAO = new DependenteDAO();
        $this->oSessao = new SessaoHandler();

        $this->oSessao->verificarSessao();
        $this->sLogin = $this->oSessao->getDado('login');


    }

    public function listar(?array $aDados = null):void{

        $this->oSessao->setDado('flo_id',$aDados['flo_id']);

        $iIdFiliadoAssociado = $this->oSessao->getDado('flo_id');
        $aDependentes = $this->oDependenteDAO->findByIdFiliado($iIdFiliadoAssociado);

        if($this->oUsuarioController->isAdmin($this->sLogin)){
            $bAparecerBotao = true;
        }else {
            $bAparecerBotao = false;
        }

        include('lista-dependentes-view.php');
        require_once __DIR__.'/../View/lista-dependentes-view.php';
    }

    public function cadastrar(?array $aDados = null):void{

        $iIdFiliadoAssociado = $this->oSessao->getDado('flo_id');

        if($this->oUsuarioController->isAdmin($this->sLogin)){
            include('cadastrar-dependente-view.php');
            require_once  __DIR__.'/../View/cadastrar-dependente-view.php';
        }else{

            echo "<script>alert('Você não tem permissão para fazer cadastro de dependente');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }

    public function deletar(?array $aDados = null):void{
        if($this->oUsuarioController->isAdmin($this->sLogin)){
            $this->oDependenteDAO->delete($aDados['dpe_id']);
            $this->listar($aDados);
        }else{
            echo "<script>alert('Você não tem permissão para deletar dependente');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }


//    public function cadastrarDependente(?array $aDados = null):void{
//
//        if($this->oUsuarioController->isAdmin($this->sLogin)){
//            $oDependente = DependenteModel::createFromArray($aDados);
//            $this->oDependenteDAO->save($oDependente);
//            $this->listar($aDados);
//        }else{
//            require_once  __DIR__.'/../View/menu-view.php';
//        }
//    }

    public function cadastrarDependente(?array $aDados = null):void{

        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->oUsuarioController->isAdmin($this->sLogin))){

            $oDependente = DependenteModel::createFromArray($aDados);;

            if(!$this->oDependenteDAO->isDependenteExiste($oDependente)){
                $this->oDependenteDAO->save($oDependente);
                $this->listar($aDados);
            }else{
                echo "<script>alert('Dependente já cadastrado. Tente novamente.');</script>";
                $this->listar($aDados);
            }
        }
    }


}