<?php
namespace Moobi\SindicatoDosEstagios\Controller;

use Exception;
use Moobi\SindicatoDosEstagios\Config\AmbienteConfig;
use Moobi\SindicatoDosEstagios\Handler\SessaoHandler;
use Moobi\SindicatoDosEstagios\Model\Filiado\FiliadoDAO;
use Moobi\SindicatoDosEstagios\Model\Filiado\FiliadoModel;
use Moobi\SindicatoDosEstagios\Utils\Validation;

/**
 * Class FiliadoController
 * @package Moobi\SindicatoDosEstagios\Controller
 * @version 1.0.0
 */
class FiliadoController {
	private FiliadoDAO $oFiliadoDAO;
	private bool $isAdmin;

	public function __construct() {
		SessaoHandler::verificarSessao();
		$this->oFiliadoDAO = new FiliadoDAO();
		$this->isAdmin = SessaoHandler::getDado('isAdmin');
	}

	/**
	 * Lista os filiados cadastrados.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function listar(?array $aDados = null): void {

		$bExibirAcoesUsuario = $this->isAdmin;

		if (isset($aDados['limpar_filtro'])) {
			SessaoHandler::unsetDado('flo_nome');
			SessaoHandler::unsetDado('flo_data_nascimento');
		}

		if (!empty($aDados['flo_nome'])) {
			SessaoHandler::setDado('flo_nome', $aDados['flo_nome']);
		}

		if (!empty($aDados['flo_data_nascimento'])) {
			SessaoHandler::setDado('flo_data_nascimento', $aDados['flo_data_nascimento']);
		}

		$sNome = SessaoHandler::getDado('flo_nome');
		$iMes = SessaoHandler::getDado('flo_data_nascimento');

		$iPagina = 1;
		$iLimite = 10;

		$iPagina = isset($aDados['pagina'])
			? filter_input(INPUT_GET, 'pagina', FILTER_VALIDATE_INT)
			: "";

		if (!$iPagina) {
			$iPagina = 1;
		}

		$iInicio = ($iPagina * $iLimite) - $iLimite;

		$iPaginas = ceil($this->oFiliadoDAO->countFiliados($iMes, $sNome) / $iLimite);

		$loFiliados = $this->oFiliadoDAO->findByFiltro($iMes, $sNome, $iInicio, $iLimite);

		include __DIR__ . '/../View/FiliadoView/lista-filiados-view.php';
	}

	/**
	 * Redireciona para o metodo cadastrarFiliado
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function cadastrar(): void {
		if ($this->isAdmin) {
			require_once __DIR__ . '/../View/FiliadoView/cadastrar-filiado-view.php';
		} else {
			echo "<script>alert('Você não tem permissão para fazer cadastro de filiado');</script>";
			$sRedirecionamento = AmbienteConfig::getUrl('usuario/menu');
			header("Location: {$sRedirecionamento}");
		}
	}

	/**
	 * Deleta um filiado.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
 */
	public function deletar(?array $aDados = null): void {
		if ($this->isAdmin) {
			$this->oFiliadoDAO->delete($aDados['flo_id']);
			$this->listar();
		} else {
			echo "<script>alert('Você não tem permissão para deletar um filiado');</script>";
			$sRedirecionamento = AmbienteConfig::getUrl('usuario/menu');
			header("Location: {$sRedirecionamento}");
		}
	}

	/**
	 *  Redireciona para o metodo atualizarFiliado.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function editar(?array $aDados = null): void {

		if ($this->isAdmin) {
			$oFiliado = FiliadoModel::createFromArray($this->oFiliadoDAO->findById($aDados['flo_id']));

			include __DIR__ . '/../View/FiliadoView/editar-filiado-view.php';
		} else {
			echo "<script>alert('Você não tem permissão para editar um filiado');</script>";
			$sRedirecionamento = AmbienteConfig::getUrl('usuario/menu');
			header("Location: {$sRedirecionamento}");
		}
	}

	/**
	 * Cadastra um novo filiado.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function cadastrarFiliado(?array $aDados = null): void {
		if (($this->isAdmin) && ($this->validarFiliado($aDados))) {
			if (!$this->oFiliadoDAO->isFiliadoExiste($aDados['flo_cpf'])) {
				$oFiliado = FiliadoModel::createFromArray($aDados);
				FiliadoModel::verificarEmpresa($oFiliado);
				$this->oFiliadoDAO->save($oFiliado);
			} else {
				echo "<script>alert('Filiado já cadastrado. Tente novamente.');</script>";
			}
			$this->listar();
		}
	}

	/**
	 * Edita dados de um filiado.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function atualizarFiliado(?array $aDados = null): void {
		if (($this->isAdmin) && ($this->validarFiliado($aDados))) {
			$oFiliado = FiliadoModel::createFromArray($aDados);
			FiliadoModel::verificarEmpresa($oFiliado);
			$this->oFiliadoDAO->update($oFiliado);
			$this->listar();
		}
	}

	/**
	 *  Valida dados de um filiado.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	private function validarFiliado(?array $aDados = null): bool {
		try {
			$aErrors = array();

			if (!Validation::validarNome($aDados['flo_nome'])) {
				$aErrors[] = "Nome inválido.";
			}

			if (!Validation::validarCpf($aDados['flo_cpf'])) {
				$aErrors[] = "CPF inválido.";
			}

			if (!Validation::validarRg($aDados['flo_rg'])) {
				$aErrors[] = "RG inválido.";
			}

			if (!Validation::validarDataNascimento($aDados['flo_data_nascimento'])) {
				$aErrors[] = "Data de nascimento invalida ou idade insuficiente.";
			}

			if (!empty($aErrors)) {
				throw new Exception(implode("", $aErrors));
			}
			return true;
		} catch (Exception $e) {
			echo "<script>alert('{$e->getMessage()}')</script>";
			$this->listar();
			return false;
		}
	}
}