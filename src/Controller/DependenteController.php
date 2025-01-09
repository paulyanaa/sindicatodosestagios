<?php
namespace Moobi\SindicatoDosEstagios\Controller;

use Exception;
use Moobi\SindicatoDosEstagios\Config\AmbienteConfig;
use Moobi\SindicatoDosEstagios\Handler\SessaoHandler;
use Moobi\SindicatoDosEstagios\Model\Dependente\DependenteDAO;
use Moobi\SindicatoDosEstagios\Model\Dependente\DependenteModel;
use Moobi\SindicatoDosEstagios\Utils\Validation;

/**
 * Class DependenteController
 * @package Moobi\SindicatoDosEstagios\Controller
 * @version 1.0.0
 */
class DependenteController {
	private DependenteDAO $oDependenteDAO;
	private string $isAdmin;

	public function __construct() {
		SessaoHandler::verificarSessao();
		$this->oDependenteDAO = new DependenteDAO();
		$this->isAdmin = SessaoHandler::getDado('isAdmin');
	}

	/**
	 *  Lista os dependentes de determinado filiado
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function listar(?array $aDados = null): void {
		$iIdFiliadoAssociado = $aDados['flo_id'];
		$loDependentes = $this->oDependenteDAO->findAllByFiliadoId($iIdFiliadoAssociado);

		if ($this->isAdmin) {
			$bExibirAcoesUsuario = true;
		} else {
			$bExibirAcoesUsuario = false;
		}
		include __DIR__ . '/../View/DependenteView/lista-dependentes-view.php';
	}

	/**
	 *  Redireciona para o metodo cadastrarDependente
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function cadastrar(?array $aDados = null): void {
		$iIdFiliadoAssociado = $aDados['flo_id'];

		if ($this->isAdmin) {
			include __DIR__ . '/../View/DependenteView/cadastrar-dependente-view.php';
		} else {
			echo "<script>alert('Você não tem permissão para fazer cadastro de dependente');</script>";
			$sRedirecionamento = AmbienteConfig::getUrl('usuario/menu');
			header("Location: $sRedirecionamento");
		}
	}

	/**
	 *  Deleta um dependente
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function deletar(?array $aDados = null): void {
		if ($this->isAdmin) {
			$this->oDependenteDAO->delete($aDados['dpe_id']);
			$this->listar($aDados);
		} else {
			echo "<script>alert('Você não tem permissão para deletar dependente');</script>";
			$sRedirecionamento = AmbienteConfig::getUrl('usuario/menu');
			header("Location: $sRedirecionamento");
		}
	}

	/**
	 *  Redireciona para o metodo atualizarDependente
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function editar(?array $aDados = null): void {
		if ($this->isAdmin) {
			$oDependente = $this->oDependenteDAO->findByIdDependenteEIdFiliado($aDados['flo_id'], $aDados['dpe_id']);
			include __DIR__ . '/../View/DependenteView/editar-dependente-view.php';
		} else {
			echo "<script>alert('Você não tem permissão para editar um filiado');</script>";
			$sRedirecionamento = AmbienteConfig::getUrl('usuario/menu');
			header("Location: $sRedirecionamento");
		}
	}

	/**
	 * Cadastra um novo dependente
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function cadastrarDependente(?array $aDados = null): void {
		if (($this->isAdmin) && ($this->validarDependente($aDados))) {
			$oDependente = DependenteModel::createFromArray($aDados);

			if (!$this->oDependenteDAO->isDependenteExiste($oDependente)) {
				$this->oDependenteDAO->save($oDependente);
			} else {
				echo "<script>alert('Dependente já cadastrado. Tente novamente.');</script>";
			}
			$this->listar($aDados);
		}
	}

	/**
	 * Edita dados de um dependente
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function atualizarDependente(?array $aDados = null): void {
		if ($this->isAdmin) {
			$oDependente = DependenteModel::createFromArray($aDados);
			$this->oDependenteDAO->update($oDependente);
			$this->listar($aDados);
		}

	}

	/**
	 *  Valida dados de um dependente
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	private function validarDependente(?array $aDados = null): bool {
		try {
			$aErrors = array();

			if (!Validation::validarNome($aDados['dpe_nome'])) {
				$aErrors[] = "Nome inválido.";
			}

			if (!Validation::validarDataNascimento($aDados['dpe_data_nascimento'])) {
				$aErrors[] = "Data de nascimento invalida ou idade insuficiente.";
			}

			if (!empty($aErrors)) {
				throw new Exception(implode("", $aErrors));
			}
			return true;
		} catch (Exception $e) {
			echo "<script>alert('{$e->getMessage()}')</script>";
			$sRedirecionamento = AmbienteConfig::getUrl('dependente/cadastrar');
			header("Location: {$sRedirecionamento}");
			return false;
		}
	}
}