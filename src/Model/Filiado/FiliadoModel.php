<?php
namespace Moobi\SindicatoDosEstagios\Model\Filiado;

use DateMalformedStringException;
use DateTime;

/**
 * Class FiliadoModel
 * @package Moobi\SindicatoDosEstagios\Model\Filiado
 * @version 1.0.0
 */
class FiliadoModel {
    private ?int $iId;
    private string $sNome;
    private string $sCpf;
    private string $sRg;
    private DateTime $sDataNascimento;
    private int $iIdade;
    private ?string $sEmpresa;
    private ?string $sCargo;
    private ?string $sSituacao;
    private string $sTelResidencial;
    private string $sTelCelular;
    private DateTime $sUltimaAtualizacao;

    public function __construct(
        ?int   $iId,
        string $sNome,
        string $sCpf,
        string $sRg,
        \DateTime $sDataNascimento,
        ?string $sEmpresa,
        ?string $sCargo,
        ?string $sSituacao,
        string $sTelResidencial,
        string $sTelCelular,
        \DateTime $sUltimaAtualizacao
    ) {
        $this->iId = $iId;
        $this->sNome = $sNome;
        $this->sCpf = $sCpf;
        $this->sRg = $sRg;
        $this->sDataNascimento = $sDataNascimento;
        $this->iIdade = (new DateTime())->diff($this->sDataNascimento)->y;
        $this->sEmpresa = $sEmpresa;
        $this->sCargo = $sCargo;
        $this->sSituacao = $sSituacao;
        $this->sTelResidencial = $sTelResidencial;
        $this->sTelCelular = $sTelCelular;
        $this->sUltimaAtualizacao = $sUltimaAtualizacao;
    }

	/**
	 * Recupera id do objeto filiado.
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
	 * Recupera o nome do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getNome() : string {
        return $this->sNome;
    }

	/**
	 * Recupera o cpf do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getCpf() : string {
        return $this->sCpf;
    }

	/**
	 * Recupera o rg do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getRg() : string {
        return $this->sRg;
    }

	/**
	 * Recupera a data de nascimento do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return DateTime
	 *
	 * @since 1.0.0
	 */
    public function getDataNascimento() : DateTime {
        return $this->sDataNascimento;
    }

	/**
	 * Recupera a idade do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return int
	 *
	 * @since 1.0.0
	 */
    public function getIdade() : int {
        return $this->iIdade;
    }

	/**
	 * Recupera a empresa do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string|null
	 *
	 * @since 1.0.0
	 */
    public function getEmpresa() : ?string {
        return $this->sEmpresa;
    }

	/**
	 * Recupera o cargo do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string|null
	 *
	 * @since 1.0.0
	 */
    public function getCargo() : ?string {
        return $this->sCargo;
    }

	/**
	 * Recupera a situação do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string|null
	 *
	 * @since 1.0.0
	 */
    public function getSituacao() : ?string {
        return $this->sSituacao;
    }

	/**
	 * Recupera o telefone residencial do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getTelResidencial() : string {
        return $this->sTelResidencial;
    }

	/**
	 * Recupera o telefone celular do objeto filiado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getTelCelular() : string {
        return $this->sTelCelular;
    }

	/**
	 * Recupera a data da ultima atualização dos dados do objeto dependente.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return DateTime
	 *
	 * @since 1.0.0
	 */
    public function getUltimaAtualizacao() : \DateTime {
        return $this->sUltimaAtualizacao;
    }

	/**
	 * Altera o cargo do objeto filiado.
	 *
	 * @param string|null $sCargo
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
    public function setCargo(?string $sCargo): void {
        $this->sCargo = $sCargo;
    }

	/**
	 * Altera o situação do objeto filiado.
	 *
	 * @param string|null $sSituacao
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
    public function setSituacao(?string $sSituacao): void {
        $this->sSituacao = $sSituacao;
    }

	/**
	 * Verifica se o atributo empresa está vazio.
	 *
	 * @param FiliadoModel $oFiliado
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0
	 */
    public static function verificarEmpresa (FiliadoModel $oFiliado) : void {
        if($oFiliado->getEmpresa() == null){
            $oFiliado->setCargo(null);
            $oFiliado->setSituacao(null);
        }
    }

	/**
	 * Cria um objeto filiado.
	 *
	 * @param array $aDadosFiliado
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return FiliadoModel
	 * @throws DateMalformedStringException
	 *
	 * @since 1.0.0
	 */
    public static function createFromArray(array $aDadosFiliado) : FiliadoModel{
        return new FiliadoModel(
            $aDadosFiliado['flo_id'],
            $aDadosFiliado['flo_nome'],
            $aDadosFiliado['flo_cpf'],
            $aDadosFiliado['flo_rg'],
            new DateTime($aDadosFiliado['flo_data_nascimento']),
            $aDadosFiliado['flo_empresa'],
            $aDadosFiliado['flo_cargo'],
            $aDadosFiliado['flo_situacao'],
            $aDadosFiliado['flo_tel_residencial'],
            $aDadosFiliado['flo_tel_celular'],
            new DateTime($aDadosFiliado['flo_ultima_atualizacao'])
        );
    }
}