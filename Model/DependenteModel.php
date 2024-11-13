<?php

namespace Model;

class DependenteModel
{
    private $iId;
    private $tDataNascimento;
    private $sGrauDeParentesco;

    public function __construct(?int $iId, string $tDataNascimento, string $sGrauDeParentesco)
    {
        $this->iId = $iId;
        $this->tDataNascimento = $tDataNascimento;
        $this->sGrauDeParentesco = $sGrauDeParentesco;
    }


}