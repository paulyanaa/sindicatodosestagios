<?php

require_once __DIR__ . '/../Config/DatabaseConfig.php';

class DatabaseHandler {
    private $pdo;
    private $inTransaction = false;
    private $rollbackTransaction = false;

    public function __construct() {
        $aDadosDB = DatabaseConfig::getConeccao();

        try {
            $this->pdo = new PDO(
				"mysql:host={$aDadosDB['host']};port={$aDadosDB['porta']};dbname={$aDadosDB['dbname']};charset=utf8",
				$aDadosDB['usuario'],
				$aDadosDB['senha']
            );
        } catch (PDOException $e) {
            echo "Erro ao tentar se conectar com o banco: " . $e->getMessage();
        }
    }

    public function query($sSql, $aParametros = [])
    {
        try {
            if (!empty($aParametros)) {
                $PDOStatement = $this->pdo->prepare($sSql);
                foreach ($aParametros as $sParametro => &$sValor) {
                    $PDOStatement->bindValue($sParametro +1, $sValor);
                }
                $PDOStatement->execute();
                return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $PDOStatement = $this->pdo->query($sSql);
                return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            echo "Erro na consulta: " . $e->getMessage();
            return false;
        }
    }

    public function execute($sSql, $aParametros = []) {
        try {
            $PDOStatement = $this->pdo->prepare($sSql);
            foreach ($aParametros as $sParametro => &$sValor) {
                $PDOStatement->bindValue($sParametro+1, $sValor);
            }
            return $PDOStatement->execute();
        } catch (PDOException $e) {
            echo "Erro na execução: " . $e->getMessage();
            return false;
        }
    }

    public function startTransaction() {
        if (!$this->inTransaction) {
            $this->pdo->beginTransaction();
            $this->inTransaction = true;
            $this->rollbackTransaction = false;
        }
    }

    public function failTransaction() {
        if ($this->inTransaction) {
            $this->rollbackTransaction = true;
        }
    }

    public function endTransaction() {
        if ($this->inTransaction) {
            if ($this->rollbackTransaction) {
                $this->pdo->rollBack();
            } else {
                $this->pdo->commit();
            }
            $this->inTransaction = false;
            $this->rollbackTransaction = false;
        }
    }
}
