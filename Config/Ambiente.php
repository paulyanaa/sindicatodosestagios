<?php


class Ambiente
{
    public static function getUrl(string $sCaminho): string
    {
        $sUrlBase = 'http://localhost:80/sindicatodosestagios/';
        return  $sUrlBase . $sCaminho;
    }
}

