<?php


class DatabaseHandler
{

    private $pdo;
    private $inTransaction = false;
    private $rollbackTransaction = false;

    public function __construct(string $sHost='localhost', string $sUsuario='root', string $sSenha='', string $sPorta='3005', string $sDbname='paulyana')
    {
        try {
            $this->pdo = new PDO("mysql:host=$sHost;port=$sPorta;dbname=$sDbname;charset=utf8", $sUsuario, $sSenha);
        } catch (PDOException $e) {
            echo "Erro ao tentar se conectar com o banco: " . $e->getMessage();
        }

    }

    public function query($sSql, $aParametros = [])
    {
        try {
            if ($aParametros != []) {
                $PDOStatement = $this->pdo->prepare($sSql);
                foreach ($aParametros as $sParametro => &$sValor) {
                    $PDOStatement->bindValue($sParametro, $sValor);
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

    public function execute($sSql, $aParametros = [])
    {
        try {
            $PDOStatement = $this->pdo->prepare($sSql);
            foreach ($aParametros as $sParametro => &$sValor) {
                $PDOStatement->bindValue($sParametro, $sValor);
            }
            return $PDOStatement->execute();

        } catch (PDOException $e) {
            echo "Erro na execução: " . $e->getMessage();
            return false;
        }
    }

    public function startTransaction()
    {
        if (!$this->inTransaction) {
            $this->pdo->beginTransaction();
            $this->inTransaction = true;
            $this->rollbackTransaction = false;
        }
    }

    public function failTransaction()
    {
        if ($this->inTransaction) {
            $this->rollbackTransaction = true;
        }
    }

    public function endTransaction()
    {
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
