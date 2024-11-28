<?php

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/../sindicatodosestagios/View/css/styles.css">
    <title>Filiados</title>
</head>
<body>
<main>

    <h1>Dependentes</h1>

    <section class="container-dependentes">
        <?php if(!empty($aDependentes)): ?>
        <div>
            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Grau de Parentesco</th>
                    <?php if($bAparecerBotao): ?>
                        <th colspan="2">Ação</th>
                    <?php endif?>

                </tr>
                </thead>
                <tbody>
                <?php foreach($aDependentes as $dependente):?>
                    <tr>
                        <td><?= $dependente->getSNome()?></td>
                        <td><?= $dependente->getTDataNascimentoFormatada()?></td>
                        <td><?= $dependente->getSGrauDeParentesco()?></td>

                        <?php if($bAparecerBotao): ?>
                            <td>
                                <form action="http://localhost/sindicatodosestagios/dependente/editar" method="post">
                                    <input type="hidden" name="id" value="<?= $dependente->getIId()  ?>">
                                    <input type="submit" class="botao-editar" value="Editar">
                                </form>
                            </td>
                            <td>
                                <form action="http://localhost/sindicatodosestagios/dependente/deletar" method="post">
                                    <input type="hidden" name="dpe_id" value="<?= $dependente->getIId() ?>">
                                    <input type="hidden" name="flo_id" value="<?= $dependente->getIIdFiliadoAssociado() ?>">
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

    <?php if($bAparecerBotao): ?>
    <form action="http://localhost/sindicatodosestagios/dependente/cadastrar" method="post">
        <input type="hidden" name="id_flo" value="<?= $iIdFiliadoAssociado?>">
        <input type="submit" class="botao-cadastar-dependente" value="Cadastrar Novo Dependente">
    </form>
    <?php endif?>
    <a class="botao-voltar-menu" href="http://localhost/sindicatodosestagios/filiado/listar">Voltar</a>
    <a class="botao-sair" href="http://localhost/sindicatodosestagios/usuario/logout">Sair</a>

</main>
</body>
</html>