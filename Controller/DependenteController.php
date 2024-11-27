<?php
require_once __DIR__ . '/../Model/DependenteDAO.php';

class DependenteController
{
    public function __construct()
    {
        $this->oDependenteDAO = new DependenteDAO();
    }

    public function listar(?array $aDados = null):void{

        $aDependentes = $this->oDependenteDAO ->findById($aDados['flo_id']);
        include('lista-dependentes-view.php');
        require_once __DIR__.'/../View/lista-dependentes-view.php';

    }
}