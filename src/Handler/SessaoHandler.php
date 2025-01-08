<?php

namespace Moobi\SindicatoDosEstagios\Handler;
class SessaoHandler {
	public static function verificarSessao(): void {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['login'])) {
			require_once __DIR__ . '/../View/GeneralView/login-view.php';
			exit();
		}
	}

	public static function deslogarSessao(): void {
		session_start();
		session_unset();
		session_destroy();
	}

	public static function getDado(string $sParametroSession): string {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		return $_SESSION[$sParametroSession] ?? '';
	}

	public static function setDado(string $sParametro, string $sValor): void {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		$_SESSION[$sParametro] = $sValor;
	}

	public static function unsetDado(string $sParametro): void {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		unset($_SESSION[$sParametro]);
	}
}
