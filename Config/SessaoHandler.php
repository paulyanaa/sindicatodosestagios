<?php
class SessaoHandler {

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function verificarSessao()
    {
        if (!isset($_SESSION['login'])) {
            require_once  __DIR__.'/../View/login-view.php';
            exit();
        }
    }

//    public function logarSessao(){
//        if (session_status() == PHP_SESSION_NONE) {
//            session_start();
//        }
//    }

    public function deslogarSessao()
    {
        session_start();
        session_unset();
        session_destroy();
    }

    public function getDado(string $sParametroSession)
    {
        return $_SESSION[$sParametroSession];
    }

    public function setDado(string $sParametro, string $sValor){
        $_SESSION[$sParametro] = $sValor;
    }



//    public function iniciarSessao()
//    {
//        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//
//            $oUsuarioController = new UsuarioController();
//
//            if ($oUsuarioController->validarSenha($_POST['login'], $_POST['senha'])){
//
//                if (session_status() == PHP_SESSION_NONE) {
//                    session_start();
//                }
//
//                $_SESSION['login'] = $_POST['login'];
//
//                $oUsuarioController->verificarTipo($_SESSION['login']);
//
//            } else {
//                header("Location: login-view.php");
//                echo "<script>alert('Usuário ou senha incorretos!');</script>";
//                exit();
//            }
//        }
//    }


}
