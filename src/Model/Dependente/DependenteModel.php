<?php
namespace Moobi\SindicatoDosEstagios\Model\Dependente;

use DateMalformedStringException;
use DateTime;

/**
 * Class DependenteModel
 * @package Moobi\SindicatoDosEstagios\Model\Dependente
 * @version 1.0.0
 */
class DependenteModel {
    private ?int $iId;
    private string $iIdFiliadoAssociado;
    private string $sNome;
    private DateTime $tDataNascimento;
    private string $sGrauDeParentesco;

    public function __construct(
		?int $iId,
		string $iIdFiliadoAssociado,
		string $sNome,
		DateTime $tDataNascimento,
		string $sGrauDeParentesco
    ) {
        $this->iId = $iId;
        $this->iIdFiliadoAssociado = $iIdFiliadoAssociado;
        $this->sNome = $sNome;
        $this->tDataNascimento = $tDataNascimento;
        $this->sGrauDeParentesco = $sGrauDeParentesco;
    }

	/**
	 * Recupera id do objeto dependente.
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
	 * Recupera o id do filiado associado ao objeto dependente.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getIdFiliadoAssociado() : string {
        return $this->iIdFiliadoAssociado;
    }

	/**
	 * Recupera o nome do objeto dependente.
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
	 * Recupera a data de nascimento do objeto dependente.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return DateTime
	 *
	 * @since 1.0.0
	 */
    public function getDataNascimento() : DateTime {
        return $this->tDataNascimento;
    }

	/**
	 * Recupera o grau de parentesco do objeto dependente em relação
	 * ao filiado associado.
	 *
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0
	 */
    public function getGrauDeParentesco() : string {
        return $this->sGrauDeParentesco;
    }

	/**
	 * Cria um objeto dependente.
	 *
	 * @param array $aDadosDependente
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return DependenteModel
	 * @throws DateMalformedStringException
	 *
	 * @since 1.0.0
	 */
    public static function createFromArray(array $aDadosDependente) : DependenteModel {
	    return new DependenteModel(
	        $aDadosDependente['dpe_id'],
	        $aDadosDependente['flo_id'],
	        $aDadosDependente['dpe_nome'],
	        new DateTime($aDadosDependente['dpe_data_nascimento']),
	        $aDadosDependente['dpe_grau_de_parentesco']
	    );
    }
}