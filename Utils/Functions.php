<?php

namespace Utils;

class Functions
{

    public function __construct()
    {
    }

    public static function validarCpf($cpf):bool{
        // Remove caracteres especiais, como ponto e hífen
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se o CPF possui 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se o CPF é composto apenas por números repetidos (exemplo: 111.111.111.11)
        if ($cpf === str_repeat($cpf[0], 11)) {
            return false;
        }

        // Calcula o primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += (int)$cpf[$i] * (10 - $i);
        }
        $digito1 = $soma % 11 < 2 ? 0 : 11 - $soma % 11;

        // Calcula o segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += (int)$cpf[$i] * (11 - $i);
        }
        $digito2 = $soma % 11 < 2 ? 0 : 11 - $soma % 11;

        // Verifica se os dois dígitos verificadores calculados são iguais aos fornecidos
        return $digito1 == (int)$cpf[9] && $digito2 == (int)$cpf[10];
    }


}