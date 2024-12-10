<?php

class SessaoHandler
{

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function verificarSessao(): void
    {
        if (!isset($_SESSION['login'])) {
            require_once __DIR__ . '/../View/login-view.php';
            exit();
        }
    }

    public function deslogarSessao(): void
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function getDado(string $sParametroSession): string
    {
        return $_SESSION[$sParametroSession];
    }

    public function setDado(string $sParametro, string $sValor): void
    {
        $_SESSION[$sParametro] = $sValor;
    }

    public function unsetDado(string $sParametro): void{
        unset($_SESSION[$sParametro]);
    }

}
