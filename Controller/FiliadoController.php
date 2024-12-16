<?php
use Model\FiliadoModel;
use Utils\Validation;

require_once __DIR__ . '/../Handler/SessaoHandler.php';
require_once __DIR__ . '/../Model/FiliadoDAO.php';
require_once __DIR__ . '/../Model/FiliadoModel.php';
require_once __DIR__ . '/../Utils/Validation.php';
require_once __DIR__ . '/../Controller/UsuarioController.php';
require_once __DIR__ . '/../Controller/DependenteController.php';
require_once __DIR__ . '/../Config/AmbienteConfig.php';

class FiliadoController {
    public function __construct() {
        $this->oFiliadoDAO = new FiliadoDAO();
        $this->oUsuarioController = new UsuarioController();
        $this->oDependenteController = new DependenteController();
        $this->oSessao = new SessaoHandler();

        $this->oSessao->verificarSessao();
        $this->sLogin = $this->oSessao->getDado('login');
        $this->isAdmin = $this->oUsuarioController->isAdmin($this->sLogin);

    }

    public function listar(?array $aDados = null) : void {
        $bAparecerBotao = $this->isAdmin;

        if(isset($aDados['limpar_filtro'])) {
            $this->oSessao->unsetDado('flo_nome');
            $this->oSessao->unsetDado('flo_data_nascimento');
        }

        if(!empty($aDados['flo_nome'])) {
            $this->oSessao->setDado('flo_nome', $aDados['flo_nome']);
        }

        if(!empty($aDados['flo_data_nascimento'])) {
            $this->oSessao->setDado('flo_data_nascimento', $aDados['flo_data_nascimento']);
        }

	    $sNome = $this->oSessao->getDado('flo_nome');
        $iMes = $this->oSessao->getDado('flo_data_nascimento');

        $iPagina = 1;
        $iLimite = 3;

        $iPagina = isset($aDados['pagina'])
            ? filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT)
            : "";

        if(!$iPagina) {
            $iPagina = 1;
        }

        $iInicio = ($iPagina * $iLimite) - $iLimite;

        $iPaginas = ceil($this->oFiliadoDAO->countFiliados($iMes,$sNome) /$iLimite);

        $loFiliados = $this->oFiliadoDAO->findByFiltro($iMes,$sNome, $iInicio, $iLimite);

        include __DIR__ . '/../View/FiliadoView/lista-filiados-view.php';
    }

    public function cadastrar() : void {
        if($this->isAdmin) {
            require_once __DIR__ . '/../View/FiliadoView/cadastrar-filiado-view.php';
        } else {
            echo "<script>alert('Você não tem permissão para fazer cadastro de filiado');</script>";
            require_once __DIR__ . '/../View/GeneralView/menu-view.php';
        }
    }

    public function deletar(?array $aDados = null) : void {
        if($this->isAdmin) {
            $this->oFiliadoDAO->delete($aDados['flo_id']);
            header("Location: " . AmbienteConfig::getUrl('filiado/listar'));
            exit;
        } else {
            echo "<script>alert('Você não tem permissão para deletar um filiado');</script>";
            require_once __DIR__ . '/../View/GeneralView/menu-view.php';
        }
    }

    public function editar(?array $aDados = null) : void{

        if($this->isAdmin) {
            $oFiliado = FiliadoModel::createFromArray($this->oFiliadoDAO->findById($aDados['flo_id']));

            include __DIR__ . '/../View/FiliadoView/editar-filiado-view.php';
        } else {
            echo "<script>alert('Você não tem permissão para editar um filiado');</script>";
            require_once __DIR__ . '/../View/GeneralView/menu-view.php';
        }
    }

    public function cadastrarFiliado(?array $aDados = null) : void {
        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->isAdmin) && ($this->validarFiliado($aDados))) {
            if(!$this->oFiliadoDAO->isFiliadoExiste($aDados['flo_cpf'])) {
                $oFiliado = FiliadoModel::createFromArray($aDados);
                FiliadoModel::verificarEmpresa($oFiliado);
                $this->oFiliadoDAO->save($oFiliado);
            } else {
                echo "<script>alert('Filiado já cadastrado. Tente novamente.');</script>";
            }
            header("Location: " . AmbienteConfig::getUrl('filiado/listar'));
            exit;
        }
    }

    public function editarFiliado(?array $aDados = null) : void {
        if(($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->isAdmin) && ($this->validarFiliado($aDados))) {
            $oFiliado = FiliadoModel::createFromArray($aDados);
            FiliadoModel::verificarEmpresa($oFiliado);
            $this->oFiliadoDAO->update($oFiliado);
            header("Location: " . AmbienteConfig::getUrl('filiado/listar'));
            exit;
        }
    }

    private function validarFiliado(?array $aDados = null) : bool
    {
        try{
            $errors = array();

            if(!Validation::validarNome($aDados['flo_nome'])) {
                $errors[] = "Nome inválido.";
            }

            if(!Validation::validarCpf($aDados['flo_cpf'])) {
                $errors[] = "CPF inválido.";
            }

            if(!Validation::validarRg($aDados['flo_rg'])) {
                $errors[] = "RG inválido.";
            }

            if(!Validation::validarDataNascimento($aDados['flo_data_nascimento'])) {
                $errors[] = "Data de nascimento invalida ou idade insuficiente.";
            }

            if(!empty($errors)){
                throw new Exception(implode("",$errors));
            }
            return true;
        } catch (Exception $e) {
            echo "<script>alert('{$e->getMessage()}')</script>";
	        $this->listar();
            return false;
        }
    }
}