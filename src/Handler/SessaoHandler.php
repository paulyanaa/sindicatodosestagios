<?php

namespace Moobi\SindicatoDosEstagios\Handler;

/**
 * Class SessaoHandler
 * @package Moobi\SindicatoDosEstagios\Handler
 * @version 1.0.0
 */
class SessaoHandler {

	/**
	 * Verifica se a sessão foi inicializada através do login.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public static function verificarSessao(): void {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['login'])) {
			require_once __DIR__ . '/../View/GeneralView/login-view.php';
			exit();
		}
	}

	/**
	 * Destroi a sessão.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public static function deslogarSessao(): void {
		session_start();
		session_unset();
		session_destroy();
	}

	/**
	 * Recupera dado armazenado na sessão.
	 *
	 * @param string $sParametroSession
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
	public static function getDado(string $sParametroSession): string {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		return $_SESSION[$sParametroSession] ?? '';
	}

	/**
	 * Armazena dado na sessão.
	 *
	 * @param string $sParametro
	 * @param string $sValor
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public static function setDado(string $sParametro, string $sValor): void {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION[$sParametro] = $sValor;
	}

	/**
	 * Deleta dado armazenado na sessão.
	 *
	 * @param string $sParametro
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public static function unsetDado(string $sParametro): void {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		unset($_SESSION[$sParametro]);
	}
}
