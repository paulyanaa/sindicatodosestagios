<?php
namespace Moobi\SindicatoDosEstagios\Model\Usuario;

/**
 * Class UsuarioModel
 * @package Moobi\SindicatoDosEstagios\Model\Usuario
 * @version 1.0.0
 */
class UsuarioModel {
    private ?int $iId;
    private string $sLogin;
    private string $sSenha;
    private string $sTipo;

    public function __construct(?int $iId, string $sLogin, string $sSenha, string $sTipo) {
        $this->iId = $iId;
        $this->sLogin = $sLogin;
        $this->sSenha = $sSenha;
        $this->sTipo = $sTipo;
    }

	/**
	 * Recupera id do objeto usuário.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return int|null
	 *
	 * @since 1.0.0
	 */
    public function getId() : ?int {
        return $this->iId;
    }

	/**
	 * Recupera o login do objeto usuário.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getLogin() : string {
        return $this->sLogin;
    }

	/**
	 * Recupera a senha do objeto usuário.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getSenha() : string {
        return $this->sSenha;
    }

	/**
	 * Recupera o tipo do objeto usuário.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getTipo() : string {
        return $this->sTipo;
    }

	/**
	 * Cria um novo objeto usuário.
	 *
	 * @param array $aDadosUsuario
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return UsuarioModel
	 *
	 * @since 1.0.0
	 */
    public static function createFromArray(array $aDadosUsuario) : UsuarioModel {
	    return new UsuarioModel(
	        $aDadosUsuario['uso_id'],
	        $aDadosUsuario['uso_login'],
	        $aDadosUsuario['uso_senha'],
	        $aDadosUsuario['uso_tipo']
	    );
    }
}