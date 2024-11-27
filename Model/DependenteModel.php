<?php

namespace Model;

class DependenteModel
{
    private $iId;

    private $iIdFiliadoAssociado;
    private $sNome;
    private $tDataNascimento;
    private $sGrauDeParentesco;

    public function __construct(?int $iId, string $iIdFiliadoAssociado, string $sNome, \DateTime $tDataNascimento, string $sGrauDeParentesco)
    {
        $this->iId = $iId;
        $this->iIdFiliadoAssociado = $iIdFiliadoAssociado;
        $this->sNome = $sNome;
        $this->tDataNascimento = $tDataNascimento;
        $this->sGrauDeParentesco = $sGrauDeParentesco;
    }

    public function getIId(): ?int
    {
        return $this->iId;
    }

    public function getIIdFiliadoAssociado(): string
    {
        return $this->iIdFiliadoAssociado;
    }


    public function getSNome(): string
    {
        return $this->sNome;
    }

    public function getTDataNascimento(): \DateTime
    {
        return $this->tDataNascimento;
    }

    public function getTDataNacimentoBanco(): string{
        return $this->tDataNascimento->format('Y-m-d');
    }


    public function getSGrauDeParentesco(): string
    {
        return $this->sGrauDeParentesco;
    }

    public static function createFromArray(array $aDadosDependente):DependenteModel{
        $oDependente = new DependenteModel(
            $aDadosDependente['dpe_id'],
            $aDadosDependente['flo_id'],
            $aDadosDependente['dpe_nome'],
            $aDadosDependente['dpe_data_nascimento'],
            $aDadosDependente['dpe_grau_de_parentesco']
        );
        return $oDependente;
    }





}