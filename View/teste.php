<?php
require_once '../Config/DatabaseHandler.php';
require_once '../Model/UsuarioModel.php';
require_once '../Controller/UsuarioController.php';

$user = new UsuarioController();


var_dump($user->findByTipo('administrador'));