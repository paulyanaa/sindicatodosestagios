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
        <form action="<?php echo AmbienteConfig::getUrl('dependente/editarDependente')?>" method="post" enctype = "multipart/form-data">

            <input type="hidden" name="dpe_id" value="<?php echo $oDependente->getIId() ?>">
            <input type="hidden" name="flo_id" value="<?php echo $oDependente->getIIdFiliadoAssociado() ?>">

            <label for="nome">Nome</label>
            <label>
                <input type="text" name="dpe_nome" placeholder="<?php echo $oDependente->getSNome()?>" >
            </label><br>

            <label for="data_de_nascimento">Data de Nascimento</label>
            <label>
                <input type="text"  value="<?php echo $oDependente->getTDataNascimentoFormatada()?>" readonly>
                <input type="hidden" name="dpe_data_nascimento" value="<?php echo $oDependente->getTDataNascimentoBanco()?>">
            </label><br>

            <label for="grau_de_parentesco">Grau de Parenesco</label>
            <label>
                <input type="text" name="dpe_grau_de_parentesco" value="<?php echo $oDependente->getSGrauDeParentesco()?>" readonly>
            </label><br>


            <input type="submit" name="cadastro" class="botao-editar" value="Editar dependente"/>
        </form>
        <a class="botao-voltar" href="<?php echo AmbienteConfig::getUrl('dependente/listar')?>?flo_id=<?=$oDependente->getIIdFiliadoAssociado()?>">Voltar</a>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>

    </section>
</main>

</body>
</html>
