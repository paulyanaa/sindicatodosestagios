<?php

namespace Moobi\SindicatoDosEstagios\Controller;

use Exception;
use Moobi\SindicatoDosEstagios\Handler\SessaoHandler;
use Moobi\SindicatoDosEstagios\Model\Dependente\DependenteDAO;
use Moobi\SindicatoDosEstagios\Model\Dependente\DependenteModel;
use Moobi\SindicatoDosEstagios\Utils\Validation;

class DependenteController
{
	public function __construct()
	{
		$this->oUsuarioController = new UsuarioController();
		$this->oDependenteDAO = new DependenteDAO();

		SessaoHandler::verificarSessao();
		$this->sLogin = SessaoHandler::getDado('login');
		$this->isAdmin = $this->oUsuarioController->isAdmin($this->sLogin);
	}

	/**
	 *
	 *  Lista os dependentes de determinado filiado
	 *
	 *  Lista todos os dependentes cadastrados com o id do filiado referente a ele
	 *
	 * @param array|null $aDados
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 *
	 * @since 1.0.0
	 *
	 * /
	 */
	public function listar(?array $aDados = null): void
	{
		$iIdFiliadoAssociado = $aDados['flo_id'];
		$loDependentes = $this->oDependenteDAO->findAll($iIdFiliadoAssociado);

		if ($this->isAdmin) {
			$bAparecerBotao = true;
		} else {
			$bAparecerBotao = false;
		}
		include __DIR__ . '/../View/DependenteView/lista-dependentes-view.php';
	}

	/**
	 *  Redireciona para o metodo cadastrarDependente
	 *
	 * @param array|null $aDados
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 *
	 * @since 1.0.0
	 */
	public function cadastrar(?array $aDados = null): void
	{
		$iIdFiliadoAssociado = $aDados['flo_id'];

		if ($this->isAdmin) {
			include __DIR__ . '/../View/DependenteView/cadastrar-dependente-view.php';
		} else {
			echo "<script>alert('Você não tem permissão para fazer cadastro de dependente');</script>";
			require_once __DIR__ . '/../View/GeneralView/menu-view.php';
		}
	}


	/**
	 *  Deleta um dependente
	 *
	 *  Deleta dependente do banco de dados atraves do id
	 *
	 * @param array|null $aDados
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 *
	 * @since 1.0.0
	 */
	public function deletar(?array $aDados = null): void
	{
		if ($this->isAdmin) {
			$this->oDependenteDAO->delete($aDados['dpe_id']);
			$this->listar($aDados);
		} else {
			echo "<script>alert('Você não tem permissão para deletar dependente');</script>";
			require_once __DIR__ . '/../View/GeneralView/menu-view.php';
		}
	}

	/**
	 *  Redireciona para o metodo editarDependente
	 *
	 * @param array|null $aDados
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 *
	 * @since 1.0.0
	 */
	public function editar(?array $aDados = null): void
	{
		if ($this->isAdmin) {
			$oDependente = $this->oDependenteDAO->findById($aDados['flo_id'], $aDados['dpe_id']);
			include __DIR__ . '/../View/DependenteView/editar-dependente-view.php';
		} else {
			echo "<script>alert('Você não tem permissão para editar um filiado');</script>";
			require_once __DIR__ . '/../View/GeneralView/menu-view.php';
		}
	}

	/**
	 * Cadastra um novo dependente
	 *
	 * Cadastra novo dependente de determinado filiado através do id do filiado e do id do dependente
	 *
	 * @param array|null $aDados
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 *
	 * @since 1.0.0
	 */
	public function cadastrarDependente(?array $aDados = null): void
	{
		if (($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->isAdmin) && ($this->validarDependente($aDados))) {
			$oDependente = DependenteModel::createFromArray($aDados);

			if (!$this->oDependenteDAO->isDependenteExiste($oDependente)) {
				$this->oDependenteDAO->save($oDependente);
				$this->listar($aDados);
			} else {
				echo "<script>alert('Dependente já cadastrado. Tente novamente.');</script>";
				$this->listar($aDados);
			}
		}
	}

	/**
	 * Edita dados de um dependente
	 *
	 * Edita dados de dependente de determinado filiado atraves do id do filiado e do id do dependente
	 *
	 * @param array|null $aDados
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 *
	 * @since 1.0.0
	 */
	public function editarDependente(?array $aDados = null): void
	{
		if ($this->isAdmin) {
			$oDependente = DependenteModel::createFromArray($aDados);
			$this->oDependenteDAO->update($oDependente);
			$this->listar($aDados);
		}
	}

	/**
	 *  Valida dados de um dependente
	 *
	 *  Valida os dados que serão inseridos
	 *
	 * @param array|null $aDados
	 * @return bool
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 *
	 * @since 1.0.0
	 */
	private function validarDependente(?array $aDados = null): bool
	{
		try {
			$errors = array();

			if (!Validation::validarNome($aDados['dpe_nome'])) {
				$errors[] = "Nome inválido.";
			}

			if (!Validation::validarDataNascimento($aDados['dpe_data_nascimento'])) {
				$errors[] = "Data de nascimento invalida ou idade insuficiente.";
			}

			if (!empty($errors)) {
				throw new Exception(implode("", $errors));
			}
			return true;
		} catch (Exception $e) {
			echo "<script>alert('{$e->getMessage()}')</script>";
			require_once __DIR__ . '/../View/DependenteView/cadastrar-dependente-view.php';
			return false;
		}
	}
}