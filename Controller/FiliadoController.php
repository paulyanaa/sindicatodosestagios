<?php


use Model\FiliadoModel;
use Utils\Functions;

require_once __DIR__ . '/../Handler/SessaoHandler.php';
require_once __DIR__ . '/../Model/FiliadoDAO.php';
require_once __DIR__ . '/../Model/FiliadoModel.php';
require_once __DIR__ . '/../Utils/Functions.php';
require_once __DIR__ . '/../Controller/UsuarioController.php';
require_once __DIR__ . '/../Controller/DependenteController.php';
require_once __DIR__ . '/../Config/AmbienteConfig.php';

class FiliadoController{
    public function __construct()
    {
        $this->oFiliadoDAO = new FiliadoDAO();
        $this->oUsuarioController = new UsuarioController();
        $this->oDependenteController = new DependenteController();
        $this->oSessao = new SessaoHandler();

        $this->oSessao->verificarSessao();
        $this->sLogin = $this->oSessao->getDado('login');
        $this->isAdmin = $this->oUsuarioController->isAdmin($this->sLogin);


    }
    public function listar(?array $aDados = null):void{

        $bAparecerBotao = $this->isAdmin;

        $iPagina = 1;
        $iLimite = 2;

        if(isset($aDados['pagina'])){
            $iPagina = filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT);
        }
        if(!$iPagina){
            $iPagina = 1;
        }

        $iInicio = ($iPagina * $iLimite) - $iLimite;

        $iPaginas = ceil(($this->oFiliadoDAO->countFiliados())/$iLimite);

//        if(isset($aDados['flo_nome']) || isset($aDados['flo_data_nascimento'])){
//            $sMes = filter_input(INPUT_GET, 'flo_data_nascimento', FILTER_VALIDATE_INT);
//            $sNome = filter_input(INPUT_GET, 'flo_nome', FILTER_VALIDATE_INT);
//            $aFiliados = $this->oFiliadoDAO->findByFiltro($aDados, $iInicio, $iLimite);
//        }else{
//            $aFiliados = $this->oFiliadoDAO->findAll($iInicio, $iLimite);
//        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $aFiliados = $this->oFiliadoDAO->findByFiltro($aDados, $iInicio, $iLimite);
        }else{
            $aFiliados = $this->oFiliadoDAO->findAll($iInicio, $iLimite);
        }

        include('lista-filiados-view.php');
        require_once __DIR__.'/../View/lista-filiados-view.php';
    }


    public function cadastrar():void{
        if($this->isAdmin){
            require_once  __DIR__.'/../View/cadastrar-filiado-view.php';
        }else{
            echo "<script>alert('Você não tem permissão para fazer cadastro de filiado');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }

    public function deletar(?array $aDados = null):void{
        if($this->isAdmin){
            $this->oFiliadoDAO->delete($aDados['flo_id']);
            $this->listar();
        }else{
            echo "<script>alert('Você não tem permissão para deletar um filiado');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }

    public function editar(?array $aDados = null):void{

        if($this->isAdmin){

            $oFiliado = FiliadoModel::createFromArray($this->oFiliadoDAO->findById($aDados['flo_id']));

            include('editar-filiado-view.php');
            require_once  __DIR__.'/../View/editar-filiado-view.php';
        }else{
            echo "<script>alert('Você não tem permissão para editar um filiado');</script>";
            require_once  __DIR__.'/../View/menu-view.php';
        }
    }

    public function cadastrarFiliado(?array $aDados = null):void{

        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->isAdmin) && ($this->validarFiliado($aDados))){
            if(!$this->oFiliadoDAO->isFiliadoExiste($aDados['flo_cpf'])){
                $oFiliado = FiliadoModel::createFromArray($aDados);
                FiliadoModel::verificarEmpresa($oFiliado);
                $this->oFiliadoDAO->save($oFiliado);

            }else{
                echo "<script>alert('Filiado já cadastrado. Tente novamente.');</script>";
            }
            $this->listar();
        }

    }public function editarFiliado(?array $aDados = null):void{
        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->isAdmin) && ($this->validarFiliado($aDados))){
            $oFiliado = FiliadoModel::createFromArray($aDados);
            FiliadoModel::verificarEmpresa($oFiliado);
            $this->oFiliadoDAO->update($oFiliado);
            $this->listar();
        }
    }

    private function validarFiliado(?array $aDados = null): bool
    {
        try{
            $errors = array();

            if(!Functions::validarNome($aDados['flo_nome'])){
                $errors[] = "Nome inválido.";
            }

            if(!Functions::validarCpf($aDados['flo_cpf'])){
                $errors[] = "CPF inválido.";
            }

            if(!Functions::validarRg($aDados['flo_rg'])){
                $errors[] = "RG inválido.";
            }

            if(!Functions::validarDataNascimento($aDados['flo_data_nascimento'])){
                $errors[] = "Data de nascimento invalida ou idade insuficiente.";
            }

            if(!empty($errors)){
                throw new Exception(implode("",$errors));
            }
            return true;

        } catch (Exception $e){
            echo "<script>alert('{$e->getMessage()}')</script>";

            require_once  __DIR__.'/../View/cadastrar-filiado-view.php';
            return false;
        }
    }


}