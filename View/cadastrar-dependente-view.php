<?php
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dependente - Cadastro</title>
</head>
<body>
<main>
    <h1>Cadastro de Dependente</h1>

    <section class="container-form">
        <form action="<?php echo AmbienteConfig::getUrl('dependente/cadastrarDependente')?>" method="post" enctype = "multipart/form-data">

            <input type="hidden" name="flo_id" value="<?php echo $iIdFiliadoAssociado?>">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="dpe_nome" placeholder="Digite o nome" required><br>

            <label for="data_nascimento">Data de nascimento</label>
            <input type="date" id="data_nascimento" name="dpe_data_nascimento" placeholder="Digite a data de nascimento" required><br>

            <div>
                <label>Grau de Parentesco</label>
                <select name="dpe_grau_de_parentesco">
                    <option value="">Selecione</option>
                    <option value="Cônjuge">Cônjuge</option>
                    <option value="Filho(a)">Filho(a)</option>
                    <option value="Pai">Pai</option>
                    <option value="Mãe">Mãe</option>
                    <option value="Animal de Estimação">Animal de Estimação</option>

                </select>
            </div>

            <input type="submit" name="cadastro" class="botao-cadastrar" value="Cadastrar Dependente"/>
        </form>
        <a class="botao-voltar" href="<?php echo AmbienteConfig::getUrl('dependente/listar')?>?flo_id=<?php echo$iIdFiliadoAssociado?>">Voltar</a>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>

    </section>
</main>

</body>
</html>
