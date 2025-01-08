<?php
namespace Moobi\SindicatoDosEstagios\Controller;

use Moobi\SindicatoDosEstagios\Handler\SessaoHandler;
use Moobi\SindicatoDosEstagios\Model\Usuario\UsuarioDAO;
use Moobi\SindicatoDosEstagios\Model\Usuario\UsuarioModel;
class UsuarioController {
	private UsuarioDAO $oUsuarioDAO;
	public function __construct() {
		$this->oUsuarioDAO = new UsuarioDAO();
	}

	public function index(): void {
		require_once __DIR__ . '/../View/GeneralView/home-view.php';
	}

	public function login(): void {
		require_once __DIR__ . '/../View/GeneralView/login-view.php';
	}

	public function logout(): void {
		SessaoHandler::deslogarSessao();
		require_once __DIR__ . '/../View/GeneralView/home-view.php';
		exit();
	}

	public function cadastrar(): void {
		SessaoHandler::verificarSessao();

		if ($this->isAdmin(SessaoHandler::getDado('login'))) {
			require_once __DIR__ . '/../View/UsuarioView/cadastrar-usuario-view.php';
		} else {
			require_once __DIR__ . '/../View/GeneralView/login-view.php';
		}
	}

	public function deletar(?array $aDados = null): void {
		SessaoHandler::verificarSessao();

		if ($this->isAdmin(SessaoHandler::getDado('login'))) {
			$this->oUsuarioDAO->delete($aDados['uso_id']);
			$this->listar();
		} else {
			require_once __DIR__ . '/../View/GeneralView/login-view.php';
		}
	}

	public function listar(): void {
		$aUsuariosAdmins = $this->oUsuarioDAO->FindByTipo('administrador');
		$aUsuariosComuns = $this->oUsuarioDAO->FindByTipo('comum');

		include __DIR__ . '/../View/UsuarioView/lista-usuarios-view.php';
	}

	public function menu(): void {
		SessaoHandler::verificarSessao();
		$sLogin = SessaoHandler::getDado('login');

		if ($this->isAdmin($sLogin)) {
			$bExibirAcoesUsuario = true;
		} else {
			$bExibirAcoesUsuario = false;
		}

		include __DIR__ . '/../View/GeneralView/menu-view.php';
		exit();
	}

	public function acessar(?array $aDados = null): void
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if ($this->validarSenha($aDados['login'], $aDados['senha'])) {
				SessaoHandler::setDado('login', $aDados['login']);
				$this->menu();
			} else {
				echo "<script>alert('Usuário ou senha incorretos!');</script>";
				$this->login();
			}
		}
	}

	public function cadastrarUsuario(?array $aDados = null): void
	{
		SessaoHandler::verificarSessao();
		$sUsuarioLogado = SessaoHandler::getDado('login');

		if (($_SERVER['REQUEST_METHOD'] === 'POST') && ($this->isAdmin($sUsuarioLogado))) {
			$oUsuario = UsuarioModel::createFromArray($aDados);

			if (!$this->oUsuarioDAO->isUsuarioExiste($oUsuario->getSLogin())) {
				$sSenhaCriptografada = password_hash($oUsuario->getSSenha(), PASSWORD_DEFAULT);
				$this->oUsuarioDAO->save($oUsuario, $sSenhaCriptografada);
			} else {
				echo "<script>alert('Login já cadastrado. Tente novamente.');</script>";
			}
			$this->listar();
		}
	}

	private function validarSenha($sLogin, $sSenha): bool
	{
		if ($this->oUsuarioDAO->isUsuarioExiste($sLogin)) {
			return password_verify($sSenha, ($this->oUsuarioDAO->senhaFindByLogin($sLogin))['uso_senha']);
		} else {
			return false;
		}
	}

	public function isAdmin($sLogin): bool
	{
		$sTipo = ($this->oUsuarioDAO->findByLogin($sLogin))['uso_tipo'];
		if ($sTipo == "administrador") {
			return true;
		} else {
			return false;
		}
	}
}



