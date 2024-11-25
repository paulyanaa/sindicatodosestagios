<?php

namespace Model;


use Cassandra\Date;
use DateTime;

class FiliadoModel
{
    private $iId;
    private $sNome;
    private $sCpf;
    private $sRg;
    private $sDataNascimento;
    private $iIdade;
    private $sEmpresa;
    private $sCargo;
    private $sSituacao;
    private $sTelResidencial;
    private $sTelCelular;
    private $sUltimaAtualizacao;

    public function __construct(
        ?int   $iId,
        string $sNome,
        string $sCpf,
        string $sRg,
        \DateTime $sDataNascimento,
        string $sIdade,
        string $sEmpresa,
        string $sCargo,
        string $sSituacao,
        string $sTelResidencial,
        string $sTelCelular,
        \DateTime $sUltimaAtualizacao
    )
    {
        $this->iId = $iId;
        $this->sNome = $sNome;
        $this->sCpf = $sCpf;
        $this->sRg = $sRg;
        $this->sDataNascimento = $sDataNascimento;
        $this->iIdade = $sIdade;
        $this->sEmpresa = $sEmpresa;
        $this->sCargo = $sCargo;
        $this->sSituacao = $sSituacao;
        $this->sTelResidencial = $sTelResidencial;
        $this->sTelCelular = $sTelCelular;
        $this->sUltimaAtualizacao = $sUltimaAtualizacao;
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

    public function getSDataNascimento(): DateTime
    {
        return $this->sDataNascimento;
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

    public function getSUltimaAtualizacao(): \DateTime
    {
        return $this->sUltimaAtualizacao;
    }

    public function getDataNascimentoFormatada(): string{
        return $this->sDataNascimento->format('d/m/Y');
    }

    public function getUltimaAtualizacaoFormatada(): string{
        return $this->sUltimaAtualizacao->format('d/m/Y');
    }

    public static function createFromArray(array $aDadosFiliado):FiliadoModel{
        $oFiliadoModel = new FiliadoModel(
            $aDadosFiliado['flo_id'],
            $aDadosFiliado['flo_nome'],
            $aDadosFiliado['flo_cpf'],
            $aDadosFiliado['flo_rg'],
            new DateTime($aDadosFiliado['flo_data_nascimento']),
            $aDadosFiliado['flo_idade'],
            $aDadosFiliado['flo_empresa'],
            $aDadosFiliado['flo_cargo'],
            $aDadosFiliado['flo_situacao'],
            $aDadosFiliado['flo_tel_residencial'],
            $aDadosFiliado['flo_tel_celular'],
            new DateTime($aDadosFiliado['flo_ultima_atualizacao'])
        );
        return $oFiliadoModel;
    }

}