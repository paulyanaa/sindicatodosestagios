<?php
namespace Moobi\SindicatoDosEstagios\Controller;

use Moobi\SindicatoDosEstagios\Handler\SessaoHandler;
use Moobi\SindicatoDosEstagios\Model\Usuario\UsuarioDAO;
use Moobi\SindicatoDosEstagios\Model\Usuario\UsuarioModel;

/**
 * Class UsuarioController
 * @package Moobi\SindicatoDosEstagios\Controller
 * @version 1.0.0
 */
class UsuarioController {
	private UsuarioDAO $oUsuarioDAO;
	public function __construct() {
		$this->oUsuarioDAO = new UsuarioDAO();
	}

	/**
	 * Redireciona o usuário para tela inicial.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function index(): void {
		require_once __DIR__ . '/../View/GeneralView/home-view.php';
	}

	/**
	 * Redireciona o usuário para tela de login.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function login(): void {
		require_once __DIR__ . '/../View/GeneralView/login-view.php';
	}

	/**
	 * Desloga o usuário.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function logout(): void {
		SessaoHandler::deslogarSessao();
		require_once __DIR__ . '/../View/GeneralView/home-view.php';
		exit();
	}

	/**
	 * Redireciona para a tela de cadastro de usuário.
	 *
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @since 1.0.0
	 */
	public function cadastrar(): void {
		SessaoHandler::verificarSessao();
		$isAdmin = $this->oUsuarioDAO->isAdmin(SessaoHandler::getDado('login'));

		if ($isAdmin) {
			require_once __DIR__ . '/../View/UsuarioView/cadastrar-usuario-view.php';
		} else {
			require_once __DIR__ . '/../View/GeneralView/login-view.php';
		}
	}

	/**
	 * Deleta um usuario.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function deletar(?array $aDados = null): void {
		SessaoHandler::verificarSessao();
		$isAdmin = $this->oUsuarioDAO->isAdmin(SessaoHandler::getDado('login'));
		if ($isAdmin) {
			$this->oUsuarioDAO->delete($aDados['uso_id']);
			$this->listar();
		} else {
			require_once __DIR__ . '/../View/GeneralView/login-view.php';
		}
	}

	/**
	 * Lista todos os usuarios.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function listar(): void {
		$aUsuariosAdmins = $this->oUsuarioDAO->FindByTipo('administrador');
		$aUsuariosComuns = $this->oUsuarioDAO->FindByTipo('comum');

		include __DIR__ . '/../View/UsuarioView/lista-usuarios-view.php';
	}

	/**
	 * Redireciona para a tela de menu.
	 *
	 * @return void
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @since 1.0.0
	 */
	public function menu(): void {
		SessaoHandler::verificarSessao();
		$isAdmin = $this->oUsuarioDAO->isAdmin(SessaoHandler::getDado('login'));
		if ($isAdmin) {
			$bExibirAcoesUsuario = true;
		} else {
			$bExibirAcoesUsuario = false;
		}

		include __DIR__ . '/../View/GeneralView/menu-view.php';
		exit();
	}

	/**
	 * Inicia sessão
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function acessar(?array $aDados = null): void {
		if ($this->validarSenha($aDados['login'], $aDados['senha'])) {
			$isAdmin = $this->oUsuarioDAO->isAdmin($aDados['login']);
			SessaoHandler::setDado('login', $aDados['login']);
			SessaoHandler::setDado('isAdmin', $isAdmin);
			$this->menu();
		} else {
			echo "<script>alert('Usuário ou senha incorretos!');</script>";
			$this->login();
		}
	}

	/**
	 * Cadastra um novo usuário.
	 *
	 * @param array|null $aDados
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function cadastrarUsuario(?array $aDados = null): void {
		SessaoHandler::verificarSessao();
		$isAdmin = $this->oUsuarioDAO->isAdmin(SessaoHandler::getDado('login'));

		if ($isAdmin){
			$oUsuario = UsuarioModel::createFromArray($aDados);
			if (!$this->oUsuarioDAO->isUsuarioExiste($oUsuario->getLogin())) {
				$sSenhaCriptografada = password_hash($oUsuario->getSenha(), PASSWORD_DEFAULT);
				$this->oUsuarioDAO->save($oUsuario, $sSenhaCriptografada);
			} else {
				echo "<script>alert('Login já cadastrado. Tente novamente.');</script>";
			}
			$this->listar();
		}
	}

	/**
	 * Valida a senha inserida no login.
	 *
	 * @param $sLogin
	 * @param $sSenha
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	private function validarSenha($sLogin, $sSenha): bool {
		if ($this->oUsuarioDAO->isUsuarioExiste($sLogin)) {
			return password_verify($sSenha, ($this->oUsuarioDAO->senhaFindByLogin($sLogin))['uso_senha']);
		} else {
			return false;
		}
	}
}



