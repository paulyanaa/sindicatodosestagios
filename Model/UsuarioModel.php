<?php

namespace Model;
require_once __DIR__ . '/../Model/UsuarioDAO.php';

class UsuarioModel
{
    private $iId;
    private $sLogin;
    private $sSenha;
    private $sTipo;

    public function __construct(?int $iId, string $sLogin, string $sSenha, string $sTipo)
    {
        $this->iId = $iId;
        $this->sLogin = $sLogin;
        $this->sSenha = $sSenha;
        $this->sTipo = $sTipo;
    }

    public function getIId(): ?int{
        return $this->iId;
    }


    public function getSLogin(){
        return $this->sLogin;
    }

    public function getSSenha(): string
    {
        return $this->sSenha;
    }

    public function getSTipo(){
        return $this->sTipo;
    }

    public static function createFromArray(array $aDadosUsuario):UsuarioModel{
        $oUsuario = new UsuarioModel(
            $aDadosUsuario['uso_id'],
            $aDadosUsuario['login'],
            $aDadosUsuario['senha'],
            $aDadosUsuario['tipo']
        );
        return $oUsuario;
    }


}