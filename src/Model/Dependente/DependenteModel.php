<?php
namespace Moobi\SindicatoDosEstagios\Model\Dependente;
class DependenteModel {
    private $iId;
    private $iIdFiliadoAssociado;
    private $sNome;
    private $tDataNascimento;
    private $sGrauDeParentesco;

    public function __construct(
		?int $iId,
		string $iIdFiliadoAssociado,
		string $sNome,
		\DateTime $tDataNascimento,
		string $sGrauDeParentesco
    ) {
        $this->iId = $iId;
        $this->iIdFiliadoAssociado = $iIdFiliadoAssociado;
        $this->sNome = $sNome;
        $this->tDataNascimento = $tDataNascimento;
        $this->sGrauDeParentesco = $sGrauDeParentesco;
    }

    public function getIId() : ?int {
        return $this->iId;
    }

    public function getIIdFiliadoAssociado() : string {
        return $this->iIdFiliadoAssociado;
    }

    public function getSNome() : string {
        return $this->sNome;
    }

    public function getTDataNascimento() : \DateTime {
        return $this->tDataNascimento;
    }

    public function getTDataNascimentoFormatada() : string{
        return $this->tDataNascimento->format('d/m/Y');
    }

    public function getTDataNascimentoBanco() : string {
        return $this->tDataNascimento->format('Y-m-d');
    }

    public function getSGrauDeParentesco() : string {
        return $this->sGrauDeParentesco;
    }

    public static function createFromArray(array $aDadosDependente) : DependenteModel {
	    return new DependenteModel(
	        $aDadosDependente['dpe_id'],
	        $aDadosDependente['flo_id'],
	        $aDadosDependente['dpe_nome'],
	        new \DateTime($aDadosDependente['dpe_data_nascimento']),
	        $aDadosDependente['dpe_grau_de_parentesco']
	    );
    }





}