<?php

namespace Model;


use Cassandra\Date;
use DateTime;

class FiliadoModel
{
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
//        string $sIdade,
        ?string $sEmpresa,
        ?string $sCargo,
        ?string $sSituacao,
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
        $this->iIdade = (new DateTime())->diff($this->sDataNascimento)->y;
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

    public function getSEmpresa(): ?string
    {
        return $this->sEmpresa;
    }



    public function getSCargo(): ?string
    {
        return $this->sCargo;
    }

    public function getSSituacao(): ?string
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

    public function getSDataNascimentoBanco(): string
    {
        return $this->sDataNascimento->format('Y-m-d');
    }

    public function getUltimaAtualizacaoFormatada(): string{
        return $this->sUltimaAtualizacao->format('d/m/Y');
    }


    public function setSCargo(?string $sCargo): void
    {
        $this->sCargo = $sCargo;
    }

    public function setSSituacao(?string $sSituacao): void
    {
        $this->sSituacao = $sSituacao;
    }

    public static function verificarEmpresa (FiliadoModel $oFiliado):void{
        if($oFiliado->getSEmpresa() == null){
            $oFiliado->setSCargo(null);
            $oFiliado->setSSituacao(null);
        }
    }


    public static function createFromArray(array $aDadosFiliado):FiliadoModel{
        $oFiliadoModel = new FiliadoModel(
            $aDadosFiliado['flo_id'],
            $aDadosFiliado['flo_nome'],
            $aDadosFiliado['flo_cpf'],
            $aDadosFiliado['flo_rg'],
            new DateTime($aDadosFiliado['flo_data_nascimento']),
//            $aDadosFiliado['flo_idade'],
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