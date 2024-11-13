<?php

namespace Model;

use MongoDB\BSON\Timestamp;

class FiliadoModel
{
    private $iId;
    private $sNome;
    private $sCpf;
    private $sRg;
    private $tDataNascimento;
    private $iIdade;
    private $sEmpresa;
    private $sCargo;
    private $sSituacao;
    private $sTelResidencial;
    private $sTelCelular;

    public function __construct(
        ?int $iId,
        string $sNome,
        string $sCpf,
        string $sRg,
        \DateTime $tDataNascimento,
        int $iIdade,
        string $sEmpresa,
        string $sCargo,
        string $sSituacao,
        string $sTelResidencial,
        string $sTelCelular)
    {
        $this->iId = $iId;
        $this->sNome = $sNome;
        $this->sCpf = $sCpf;
        $this->sRg = $sRg;
        $this->tDataNascimento = $tDataNascimento;
        $this->iIdade = $iIdade;
        $this->sEmpresa = $sEmpresa;
        $this->sCargo = $sCargo;
        $this->sSituacao = $sSituacao;
        $this->sTelResidencial = $sTelResidencial;
        $this->sTelCelular = $sTelCelular;
    }

    public function getIId(): ?int
    {
        return $this->iId;
    }

    public function getSNome(): string
    {
        return $this->sNome;
    }

    public function getSCpf(): string
    {
        return $this->sCpf;
    }

    public function getSRg(): string
    {
        return $this->sRg;
    }

    public function getTDataNascimento(): \DateTime
    {
        return $this->tDataNascimento;
    }

    public function getIIdade(): int
    {
        return $this->iIdade;
    }

    public function getSEmpresa(): string
    {
        return $this->sEmpresa;
    }

    public function getSCargo(): string
    {
        return $this->sCargo;
    }

    public function getSSituacao(): string
    {
        return $this->sSituacao;
    }

    public function getSTelResidencial(): string
    {
        return $this->sTelResidencial;
    }

    public function getSTelCelular(): string
    {
        return $this->sTelCelular;
    }


}