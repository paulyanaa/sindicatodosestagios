<?php
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/styles.css">
    <title>Filiado - Edição</title>
</head>
<body>
<main>
    <h1>Edição de Filiado</h1>

    <section class="container-form">
        <form action="http://localhost/sindicatodosestagios/filiado/editarFiliado" method="post" enctype = "multipart/form-data">

            <input type="hidden" name="flo_id" value="<?= $oFiliado->getIId() ?>">

            <label for="nome">Nome</label>
            <label>
            <input type="text" name="flo_nome" value="<?= $oFiliado->getSNome()?>" readonly>
            </label><br>

            <label for="cpf">CPF</label>
            <label>
                <input type="text" name="flo_cpf" value="<?= $oFiliado->getSCPF()?>" readonly>
            </label><br>

            <label for="rg">RG</label>
            <label>
                <input type="text" name="flo_rg" value="<?= $oFiliado->getSRg()?>" readonly>
            </label><br>

            <label for="data_nascimento">Data de nascimento </label>
            <label>
                <input type="text"  value="<?= $oFiliado->getDataNascimentoFormatada()?>" readonly>
                <input type="hidden" name="flo_data_nascimento" value="<?= $oFiliado->getSDataNascimentoBanco()?>">
            </label><br>

            <label for="idade">Idade</label>
            <label>
                <input type="text" name="flo_idade" value="<?= $oFiliado->getIIdade()?>" readonly>
            </label><br>

            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="flo_empresa" value="<?= $oFiliado->getSEmpresa()?>" ><br>

            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="flo_cargo" value="<?= $oFiliado->getSCargo()?>"><br>

            <div>
                <label>Situação </label>
                <select name="flo_situacao">
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Aposentado </option>
                    <option value="Aposentado">Inativo </option>
                    <option value="Licenciado">Licenciado </option>
                </select>
            </div>

            <label for="tel_residencial">Telefone Residencial </label>
            <label>
                <input type="text" name="flo_tel_residencial" value="<?= $oFiliado->getSTelResidencial()?>" readonly>
            </label><br>

            <label for="tel_celular">Telefone Celular</label>
            <label>
                <input type="text" name="flo_tel_celular" value="<?= $oFiliado->getSTelCelular()?>" readonly>
            </label><br>

            <input type="submit" name="cadastro" class="botao-cadastrar" value="Editar filiado"/>
        </form>
        <a class="botao-voltar" href="http://localhost/sindicatodosestagios/filiado/listar">Voltar</a>
        <a class="botao-sair" href="http://localhost/sindicatodosestagios/usuario/logout">Sair</a>

    </section>
</main>

</body>
</html>
