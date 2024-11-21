<?php

use Model\FiliadoModel;

require_once __DIR__ . '/../Config/DatabaseHandler.php';
require_once __DIR__ . '/../Model/FiliadoDAO.php';
class FiliadoController{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler();
        $this->oFiliadoDAO = new FiliadoDAO();

    }
    public function listar()
    {
        $aFiliados= $this->oFiliadoDAO->findAll();

        include('lista-filiados-view.php');
        require_once __DIR__.'/../View/lista-filiados-view.php';
    }


}