<?php
use Moobi\SindicatoDosEstagios\Config\AmbienteConfig;
use Moobi\SindicatoDosEstagios\Model\Dependente\DependenteModel;

/** @var DependenteModel $oDependente */
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
        <form action="<?php echo AmbienteConfig::getUrl('dependente/atualizarDependente')?>" method="post" enctype = "multipart/form-data">

            <input type="hidden" name="dpe_id" value="<?php echo $oDependente->getId() ?>">
            <input type="hidden" name="flo_id" value="<?php echo $oDependente->getIdFiliadoAssociado() ?>">

            <label for="nome">Nome</label>
            <label>
                <input type="text" name="dpe_nome" placeholder="<?php echo $oDependente->getNome()?>" >
            </label><br>

            <label for="data_de_nascimento">Data de Nascimento</label>
            <label>
                <input type="text"  value="<?php echo $oDependente->getDataNascimento()->format('d/m/Y')?>" readonly>
                <input type="hidden" name="dpe_data_nascimento" value="<?php echo $oDependente->getDataNascimento()->format('Y-m-d')?>">
            </label><br>

            <label for="grau_de_parentesco">Grau de Parentesco</label>
            <label>
                <input type="text" name="dpe_grau_de_parentesco" value="<?php echo $oDependente->getGrauDeParentesco()?>" readonly>
            </label><br>


            <input type="submit" name="cadastro" class="botao-editar" value="Editar dependente"/>
        </form>
        <a class="botao-voltar" href="<?php echo AmbienteConfig::getUrl('dependente/listar')?>?flo_id=<?=$oDependente->getIdFiliadoAssociado()?>">Voltar</a>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>

    </section>
</main>

</body>
</html>
