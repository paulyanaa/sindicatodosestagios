<?php

class PostHandler
{
    public function __construct()
    {
    }

    public function getDado(string $sParametroPost){
        return $_POST[$sParametroPost];
    }

    public function verificarOcorrencia():bool{
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        } else {
            return false;
        }
    }

}