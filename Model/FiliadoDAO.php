<?php



use Model\FiliadoModel;

require_once __DIR__ . '/../Handler/DatabaseHandler.php';
require_once __DIR__ . '/../Model/FiliadoModel.php';
class FiliadoDAO{
    public function __construct()
    {
        $this->oDatabase = new DatabaseHandler();
    }


    public function save(FiliadoModel $oFiliado):void{

        $sSql = "INSERT INTO flo_filiado (flo_nome, flo_cpf, flo_rg, flo_data_nascimento, flo_empresa, flo_cargo, flo_situacao, flo_tel_residencial, flo_tel_celular, flo_ultima_atualizacao) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
        $sParametros = [
            1 => $oFiliado ->getSNome(),
            2 => $oFiliado ->getSCpf(),
            3 => $oFiliado ->getSRg(),
            4 => ($oFiliado ->getSDataNascimento())->format('Y-m-d'),
            5 => $oFiliado ->getSEmpresa(),
            6 => $oFiliado ->getSCargo(),
            7 => $oFiliado ->getSSituacao(),
            8 => $oFiliado ->getSTelResidencial(),
            9 => $oFiliado ->getSTelCelular()
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function delete(int $iId):void{

        $sSql = "DELETE FROM flo_filiado WHERE flo_filiado.flo_id = ?";
        $sParametros = [
            1 => $iId,
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }

    public function update(FiliadoModel $oFiliado):void{


        $sSql = "UPDATE flo_filiado SET flo_empresa = ?, flo_cargo = ?, flo_situacao = ?, flo_ultima_atualizacao = CURDATE() WHERE flo_filiado.flo_id = ?";
        $sParametros = [
            1 => $oFiliado->getSEmpresa(),
            2 => $oFiliado->getSCargo(),
            3 => $oFiliado->getSSituacao(),
            4 => $oFiliado->getIId()
        ];
        $this->oDatabase->execute($sSql, $sParametros);
    }


    public function findAll($iInicio, $iLimite):array{

        $sSql = "SELECT * FROM flo_filiado ORDER BY flo_nome LIMIT {$iInicio}, {$iLimite}";

        $aFiliados = $this->oDatabase->query($sSql);

        $aObjFiliado = array_map(function($filiado){
            return FiliadoModel::createFromArray($filiado);
        }, $aFiliados);

        return $aObjFiliado;
    }

    public function isFiliadoExiste(string $sCpf):bool
    {
        $sSql ="SELECT 1 FROM flo_filiado WHERE flo_cpf = ? LIMIT 1";
        $sParametro = [1 => $sCpf];
        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
        return !empty($aResultadoConsulta);
    }

    public function findById($id):array
    {
        $sSql = "SELECT * FROM flo_filiado WHERE flo_id = ?";
        $sParametro = [1 => $id];
        $aResultadoConsulta = $this->oDatabase->query($sSql, $sParametro);
        return $aResultadoConsulta[0];
    }

    public function findByFiltro(?array $aDados, $iInicio, $iLimite)
    {

        $sSql = "SELECT * FROM flo_filiado WHERE 1=1";
        $aParametro = [];

        if(!empty($aDados['flo_nome'])){
            $sSql .= " AND flo_nome LIKE ?";
            $aParametro = [
                1 => "%".$aDados['flo_nome']."%"
            ];
        }
        if(!empty($aDados['flo_data_nascimento'])){
            $sSql .= " AND MONTH(flo_data_nascimento) = ?";
            $aParametro = [
                1 => intval($aDados['flo_data_nascimento'])
            ];
        }

        $sSql .= " ORDER BY flo_nome LIMIT {$iInicio}, {$iLimite}";

        $aFiliados = $this->oDatabase->query($sSql, $aParametro);

        $aObjFiliado = array_map(function($filiado){
            return FiliadoModel::createFromArray($filiado);
        }, $aFiliados);

        return $aObjFiliado;

    }

    public function countFiliados(){
        $sSql = "SELECT COUNT(flo_cpf) AS total FROM flo_filiado";
        $aConsulta = $this->oDatabase->query($sSql);
        return $aConsulta[0]['total'];
    }

}