<?php
use Moobi\SindicatoDosEstagios\Config\AmbienteConfig;
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo AmbienteConfig::getUrl('View/css/styles.css')?>">
    <title>Dependentes</title>
</head>
<body>
<main>
    <h1>Dependentes</h1>
    <section class="container-dependentes">
        <?php if(!empty($loDependentes)): ?>
        <div>
            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Grau de Parentesco</th>
                    <?php if($bExibirAcoesUsuario): ?>
                        <th colspan="2">Ação</th>
                    <?php endif?>

                </tr>
                </thead>
                <tbody>
                <?php foreach($loDependentes as $dependente):?>
                    <tr>
                        <td><?php echo $dependente->getSNome()?></td>
                        <td><?php echo $dependente->getTDataNascimentoFormatada()?></td>
                        <td><?php echo $dependente->getSGrauDeParentesco()?></td>

                        <?php if($bExibirAcoesUsuario): ?>
                            <td>
                                <form action="<?php echo AmbienteConfig::getUrl('dependente/editar')?>" method="post">
                                    <input type="hidden" name="dpe_id" value="<?php echo $dependente->getIId()  ?>">
                                    <input type="hidden" name="flo_id" value="<?php echo $dependente->getIIdFiliadoAssociado()?>">
                                    <input type="submit" class="botao-editar" value="Editar">
                                </form>
                            </td>
                            <td>
                                <form action="<?php echo AmbienteConfig::getUrl('dependente/deletar')?>" method="post">
                                    <input type="hidden" name="dpe_id" value="<?php echo $dependente->getIId() ?>">
                                    <input type="hidden" name="flo_id" value="<?php echo $dependente->getIIdFiliadoAssociado()?>">
                                    <input type="submit" class="botao-excluir" value="Excluir">
                                </form>
                            </td>
                        <?php endif?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <?php else:?>
        <h2>Nenhum dependente cadastrado até o momento!</h2>
        <?php endif?>
    </section>
    <?php if($bExibirAcoesUsuario): ?>
        <a class="botao-voltar-menu" href="<?php echo AmbienteConfig::getUrl('dependente/cadastrar')?>?flo_id=<?= $iIdFiliadoAssociado?>">Cadastrar Novo Dependente</a><br>
    <?php endif?>
    <a class="botao-voltar-menu" href="<?php echo AmbienteConfig::getUrl('filiado/listar')?>">Voltar</a>
    <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>

</main>
</body>
</html>