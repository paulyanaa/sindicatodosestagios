<?php
namespace Moobi\SindicatoDosEstagios\Model\Usuario;

use Moobi\SindicatoDosEstagios\Handler\DatabaseHandler;
class UsuarioDAO
{

	private DatabaseHandler $oDatabase;

	public function __construct()
	{
		$this->oDatabase = new DatabaseHandler();
	}

	public function isUsuarioExiste($sLogin): bool
	{
		$sSql = "SELECT 1 FROM uso_usuario WHERE uso_login = ? LIMIT 1";
		$aParametro = [$sLogin];
		return !empty($this->oDatabase->query($sSql, $aParametro));
	}

	public function save(UsuarioModel $oUsuario, string $sSenhaCriptografada): void
	{
		$sSql = "INSERT INTO uso_usuario (uso_login, uso_senha, uso_tipo) VALUES (?, ?, ?)";
		$aParametros = [
			$oUsuario->getSLogin(),
			$sSenhaCriptografada,
			$oUsuario->getSTipo()
		];
		$this->oDatabase->execute($sSql, $aParametros);
	}

	public function delete(int $iIdUsuario): void
	{
		$sSql = "DELETE FROM uso_usuario WHERE uso_usuario.uso_id = ?";
		$aParametro = [$iIdUsuario];
		$this->oDatabase->execute($sSql, $aParametro);
	}


	public function findAll(): array
	{
		$sSql = "SELECT * FROM uso_usuario";
		$aUsuarios = $this->oDatabase->query($sSql);

		return array_map(function ($usuario) {
			return UsuarioModel::createFromArray($usuario);
		}, $aUsuarios);
	}


	public function FindByTipo($sTipo): array
	{
		$sSql = " SELECT * FROM uso_usuario WHERE uso_tipo = ? ";
		$aParametro = [$sTipo];
		$aUsuarios = $this->oDatabase->query($sSql, $aParametro);

		return array_map(function ($usuario) {
			return UsuarioModel::createFromArray($usuario);
		}, $aUsuarios);
	}

	public function FindByLogin($sLogin): array
	{
		$sSql = " SELECT * FROM uso_usuario WHERE uso_login = ? ";
		$aParametro = [$sLogin];
		$aResultadoConsulta = $this->oDatabase->query($sSql, $aParametro);

		if (!empty($aResultadoConsulta)) {
			return $aResultadoConsulta[0];
		} else {
			return [];
		}
	}

	public function senhaFindByLogin($sLogin): array
	{
		$sSql = " SELECT uso_senha FROM uso_usuario WHERE uso_login = ? ";
		$sParametro = [$sLogin];
		$aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
		if (!empty($aResultadoConsulta)) {
			return $aResultadoConsulta[0];
		} else {
			return [];
		}
	}
}