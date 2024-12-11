<?php
namespace Utils;

use DateTime;

class Validation {
    public static function validarNome($sNome) : bool {
		$sNome = trim($sNome);

        if (empty($sNome)) {
            return false;
        }
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s'-]+$/", $sNome)) {
            return false;
        }
        if (strlen($sNome) < 2 || strlen($sNome) > 100) {
            return false;
        }
        return true;
    }

    public static function validarCpf($sCpf) : bool {
        $sCpf = preg_replace('/[^0-9]/', '', $sCpf);

        if (strlen($sCpf) != 11) {
            return false;
        }

        if ($sCpf === str_repeat($sCpf[0], 11)) {
            return false;
        }

        $iSoma = 0;
        for ($i = 0; $i < 9; $i++) {
            $iSoma += (int)$sCpf[$i] * (10 - $i);
        }
        $digito1 = $iSoma % 11 < 2 ? 0 : 11 - $iSoma % 11;

        $iSoma = 0;
        for ($i = 0; $i < 10; $i++) {
            $iSoma += (int)$sCpf[$i] * (11 - $i);
        }
        $digito2 = $iSoma % 11 < 2 ? 0 : 11 - $iSoma % 11;
        return $digito1 == (int)$sCpf[9] && $digito2 == (int)$sCpf[10];
    }

    public static function validarRg($sRg): bool {
        $pattern = '/^\d{1,2}\.\d{3}\.\d{3}-\d{1}$/';
        if (preg_match($pattern, $sRg)) {
            return true;
        } else {
            return false;
        }
    }

    public static function validarDataNascimento($sDataNascimento) : bool {
        $sData = DateTime::createFromFormat('Y-m-d', $sDataNascimento);

        if (!$sData || $sData->format('Y-m-d') !== $sDataNascimento) {
            return false;
        }
        $hoje = new DateTime();
        $iIdade = $hoje->diff($sData)->y;

        if ($iIdade < 0 || $iIdade > 120) {
            return false;
        }
        return true;
    }

}