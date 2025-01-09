<?php
namespace Moobi\SindicatoDosEstagios\Utils;

use DateTime;

/**
 * Class Validation
 * @package Moobi\SindicatoDosEstagios\Utils
 * @version 1.0.0
 */
class Validation {

	/**
	 * Valida escrita de nome.
	 *
	 * @param string $sNome
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
    public static function validarNome(string $sNome) : bool {
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

	/**
	 * Valida cpf.
	 *
	 * @param string $sCpf
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
    public static function validarCpf(string $sCpf) : bool {
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
        $iDigito1 = $iSoma % 11 < 2 ? 0 : 11 - $iSoma % 11;

        $iSoma = 0;
        for ($i = 0; $i < 10; $i++) {
            $iSoma += (int)$sCpf[$i] * (11 - $i);
        }
        $iDigito2 = $iSoma % 11 < 2 ? 0 : 11 - $iSoma % 11;
        return $iDigito1 == (int)$sCpf[9] && $iDigito2 == (int)$sCpf[10];
    }

	/**
	 * Valida RG.
	 *
	 * @param string $sRg
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
    public static function validarRg(string $sRg): bool {
        $sPadrao = '/^\d{1,2}\.\d{3}\.\d{3}-\d{1}$/';
        if (preg_match($sPadrao, $sRg)) {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * Valida data de nascimento.
	 *
	 * @param string $sDataNascimento
	 * @author Paulyana Ferreira paulyanasilva@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0
	 */
    public static function validarDataNascimento(string $sDataNascimento) : bool {
        $sData = DateTime::createFromFormat('Y-m-d', $sDataNascimento);

        if (!$sData || $sData->format('Y-m-d') !== $sDataNascimento) {
            return false;
        }
        $tHoje = new DateTime();
        $iIdade = $tHoje->diff($sData)->y;

        if ($iIdade < 0 || $iIdade > 120) {
            return false;
        }
        return true;
    }
}