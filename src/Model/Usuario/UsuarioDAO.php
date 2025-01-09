<?php
namespace Moobi\SindicatoDosEstagios\Model\Usuario;

use Moobi\SindicatoDosEstagios\Handler\DatabaseHandler;

/**
 * Class UsuarioDAO
 * @package Moobi\SindicatoDosEstagios\Model\Usuario
 * @version 1.0.0
 */
class UsuarioDAO {
	private DatabaseHandler $oDatabase;

	public function __construct() {
		$this->oDatabase = new DatabaseHandler();
	}

	/**
	 * Verifica se determinado usuário já está cadastrado no banco de dados.
	 *
	 * @param $sLogin
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function isUsuarioExiste($sLogin): bool {
		$sSql = "SELECT 1 FROM uso_usuario WHERE uso_login = ? LIMIT 1";
		$aParametro = [$sLogin];
		return !empty($this->oDatabase->query($sSql, $aParametro));
	}

	/**
	 * Salva os dados do usuário no banco de dados.
	 *
	 * @param UsuarioModel $oUsuario
	 * @param string $sSenhaCriptografada
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function save(UsuarioModel $oUsuario, string $sSenhaCriptografada): void {
		$sSql = "INSERT INTO uso_usuario (uso_login, uso_senha, uso_tipo) VALUES (?, ?, ?)";
		$aParametros = [
			$oUsuario->getLogin(),
			$sSenhaCriptografada,
			$oUsuario->getTipo()
		];
		$this->oDatabase->execute($sSql, $aParametros);
	}

	/**
	 * Exclui os dados de determinado usuário do banco de dados.
	 *
	 * @param int $iIdUsuario
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function delete(int $iIdUsuario): void {
		$sSql = "DELETE FROM uso_usuario WHERE uso_usuario.uso_id = ?";
		$aParametro = [$iIdUsuario];
		$this->oDatabase->execute($sSql, $aParametro);
	}

	/**
	 * Busca todos os usuários cadastrados.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function findAll(): array
	{
		$sSql = "SELECT * FROM uso_usuario";
		$aUsuarios = $this->oDatabase->query($sSql);

		return array_map(function ($usuario) {
			return UsuarioModel::createFromArray($usuario);
		}, $aUsuarios);
	}

	/**
	 * Busca um usuário específico pelo tipo.
	 *
	 * @param $sTipo
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function FindByTipo($sTipo): array {
		$sSql = " SELECT * FROM uso_usuario WHERE uso_tipo = ? ";
		$aParametro = [$sTipo];
		$aUsuarios = $this->oDatabase->query($sSql, $aParametro);

		return array_map(function ($usuario) {
			return UsuarioModel::createFromArray($usuario);
		}, $aUsuarios);
	}

	/**
	 * Busca um usuário específico pelo login.
	 *
	 * @param $sLogin
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function FindByLogin($sLogin): array {
		$sSql = " SELECT * FROM uso_usuario WHERE uso_login = ? ";
		$aParametro = [$sLogin];
		$aResultadoConsulta = $this->oDatabase->query($sSql, $aParametro);

		if (!empty($aResultadoConsulta)) {
			return $aResultadoConsulta[0];
		} else {
			return [];
		}
	}

	/**
	 * Busca senha pelo login do usuário.
	 *
	 * @param $sLogin
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return array
	 *
	 * @since 1.0.0
	 */
	public function senhaFindByLogin($sLogin): array {
		$sSql = " SELECT uso_senha FROM uso_usuario WHERE uso_login = ? ";
		$sParametro = [$sLogin];
		$aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
		if (!empty($aResultadoConsulta)) {
			return $aResultadoConsulta[0];
		} else {
			return [];
		}
	}

	/**
	 * Verifica se o usuśrio é do tipo administrador.
	 *
	 * @param $sLogin
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
	public function isAdmin($sLogin): bool {
		$sTipo = ($this->findByLogin($sLogin))['uso_tipo'];
		if ($sTipo == "administrador") {
			return true;
		} else {
			return false;
		}
	}
}