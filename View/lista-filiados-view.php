<?php

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Filiados</title>
</head>
<body>
<main>

    <h1>Filiados Cadastrados</h1>


    <section class="container-filiados">
        <div>
            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>RG</th>
                    <th>Data de Nascimento</th>
                    <th>Idade</th>
                    <th>Empresa</th>

                    <th>Cargo</th>
                    <th>Situação</th>
                    <th>Telefone Residencial</th>
                    <th>Telefone Celular</th>
                    <th>Útima atualização</th>
                    <th>Dependentes</th>
                    <th colspan="2">Ação</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach($aFiliados as $filiado):?>
                    <tr>
                        <td><?= $filiado->getSNome() ?></td>
                        <td><?= $filiado->getSCpf() ?></td>
                        <td><?= $filiado->getSRg() ?></td>
                        <td><?= $filiado->getDataNascimentoFormatada()?></td>
                        <td><?= $filiado->getIIdade() ?></td>
                        <td><?= $filiado->getSEmpresa() ?></td>
                        <td><?= $filiado->getSCargo() ?></td>
                        <td><?= $filiado->getSSituacao() ?></td>
                        <td><?= $filiado->getSTelResidencial() ?></td>
                        <td><?= $filiado->getSTelCelular() ?></td>
                        <td><?= $filiado->getUltimaAtualizacaoFormatada() ?></td>
                        <td>
                            <form action="lista-dependentes-view.php" method="post">
                                <input type="hidden" name="id" value="<?= $filiado->getIId() ?>">
                                <input type="submit" class="botao-dependentes" value="Visualizar dependentes">
                            </form>
                        </td>
                        <td><a class="botao-editar" href="editar-filiado.php?id=<?= $filiado->getIId() ?>">Editar</a></td>
                        <td>
                            <form action="excluir-filiado.php" method="post">
                                <input type="hidden" name="id" value="<?= $filiado->getIId() ?>">
                                <input type="submit" class="botao-excluir" value="Excluir">
                            </form>
                        </td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>

    <a class="botao-cadastrar-filiado" href="http://localhost/sindicatodosestagios/filiado/cadastrar">Cadastrar Novo Filiado</a>
    <a class="botao-sair" href="http://localhost/sindicatodosestagios/usuario/logout">Sair</a>

</main>
</body>
</html>
