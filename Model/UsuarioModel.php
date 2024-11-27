<?php

namespace Model;
require_once __DIR__ . '/../Model/UsuarioDAO.php';

class UsuarioModel
{
    private ?int $iId;
    private string $sLogin;
    private string $sSenha;
    private string $sTipo;

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


    public function getSLogin():string{
        return $this->sLogin;
    }

    public function getSSenha(): string
    {
        return $this->sSenha;
    }

    public function getSTipo(): string{
        return $this->sTipo;
    }

    public static function createFromArray(array $aDadosUsuario):UsuarioModel{
        $oUsuario = new UsuarioModel(
            $aDadosUsuario['uso_id'],
            $aDadosUsuario['uso_login'],
            $aDadosUsuario['uso_senha'],
            $aDadosUsuario['uso_tipo']
        );
        return $oUsuario;
    }


}