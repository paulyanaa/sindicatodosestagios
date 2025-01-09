<?php
use Moobi\SindicatoDosEstagios\Config\AmbienteConfig;
use Moobi\SindicatoDosEstagios\Model\Filiado\FiliadoModel;

    /** @var FiliadoModel $oFiliado */
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo AmbienteConfig::getUrl('View/css/styles.css')?>">
    <title>Filiado - Edição</title>
</head>
<body>
<main>
    <h1>Edição de Filiado</h1>

    <section class="container-form">
        <form action="<?php echo AmbienteConfig::getUrl('filiado/atualizarFiliado')?>" method="post" enctype = "multipart/form-data">

            <input type="hidden" name="flo_id" value="<?php echo $oFiliado->getId() ?>">

            <label for="nome">Nome</label>
            <label>
            <input type="text" name="flo_nome" value="<?php echo $oFiliado->getNome()?>" readonly>
            </label><br>

            <label for="cpf">CPF</label>
            <label>
                <input type="text" name="flo_cpf" value="<?php echo $oFiliado->getCPF()?>" readonly>
            </label><br>

            <label for="rg">RG</label>
            <label>
                <input type="text" name="flo_rg" value="<?php echo $oFiliado->getRg()?>" readonly>
            </label><br>

            <label for="data_nascimento">Data de nascimento </label>
            <label>
                <input type="text"  value="<?php echo $oFiliado->getDataNascimento()->format('d/m/Y')?>" readonly>
                <input type="hidden" name="flo_data_nascimento" value="<?php echo $oFiliado->getDataNascimento()->format('Y-m-d')?>">
            </label><br>

            <label for="idade">Idade</label>
            <label>
                <input type="text" name="flo_idade" value="<?php echo $oFiliado->getIdade()?>" readonly>
            </label><br>

            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="flo_empresa" value="<?php echo $oFiliado->getEmpresa()?>" ><br>

            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="flo_cargo" value="<?php echo $oFiliado->getCargo()?>"><br>

            <div>
                <label>Situação</label>
                <select name="flo_situacao">
                    <option value="">Selecione</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Inativo </option>
                    <option value="Aposentado">Aposentado </option>
                    <option value="Licenciado">Licenciado </option>
                </select>
            </div>

            <label for="tel_residencial">Telefone Residencial </label>
            <label>
                <input type="text" name="flo_tel_residencial" value="<?php echo $oFiliado->getTelResidencial()?>" readonly>
            </label><br>

            <label for="tel_celular">Telefone Celular</label>
            <label>
                <input type="text" name="flo_tel_celular" value="<?php echo $oFiliado->getTelCelular()?>" readonly>
            </label><br>

            <input type="submit" name="cadastro" class="botao-cadastrar" value="Editar filiado"/>
        </form>
        <a class="botao-voltar" href="<?php echo AmbienteConfig::getUrl('filiado/listar')?>">Voltar</a>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>

    </section>
</main>

</body>
</html>
