<?php
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--    <link rel="stylesheet" href="--><?php //echo AmbienteConfig::getUrl('View/css/styles.css')?><!--">-->
    <title>Filiado - Cadastro</title>
</head>
<body>
<main>
    <h1>Cadastro de Filiado</h1>

    <section class="container-form">
        <form action="<?php echo AmbienteConfig::getUrl('filiado/cadastrarFiliado')?>" method="post" enctype = "multipart/form-data">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="flo_nome" placeholder="Digite o nome" required><br>

            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="flo_cpf" placeholder="Digite o CPF" required><br>

            <label for="rg">RG</label>
            <input type="text" id="rg" name="flo_rg" placeholder="Digite o RG" required><br>

            <label for="data_nascimento">Data de nascimento</label>
            <input type="date" id="data_nascimento" name="flo_data_nascimento" placeholder="Digite a data de nascimento" required><br>

            <label for="empresa">Empresa</label>
            <input type="text" id="empresa" name="flo_empresa" placeholder="Digite o nome da empresa" ><br>

            <label for="cargo">Cargo</label>
            <input type="text" id="cargo" name="flo_cargo" placeholder="Digite o nome da empresa" ><br>

            <div>
                <label>Situacao</label>
                <select name="flo_situacao">
                    <option value="">Selecione</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Inativo">Aposentado</option>
                    <option value="Aposentado">Inativo</option>
                    <option value="Licenciado">Licenciado</option>
                </select>
            </div>

            <label for="tel_residencial">Telefone Residencial</label>
            <input type="tel" id="tel_residencial" name="flo_tel_residencial" placeholder="Digite o nome da empresa" required><br>

            <label for="tel_celular">Telefone Celular</label>
            <input type="tel" id="tel_celular" name="flo_tel_celular" placeholder="Digite o nome da empresa" required><br>

            <input type="submit" name="cadastro" class="botao-cadastrar" value="Cadastrar filiado"/>
        </form>
        <a class="botao-voltar" href="<?php echo AmbienteConfig::getUrl('filiado/listar')?>">Voltar</a>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>

    </section>
</main>

</body>
</html>
