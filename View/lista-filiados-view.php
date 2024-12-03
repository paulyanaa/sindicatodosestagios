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

    <h1>Filiados Cadastrados</h1>

    <form action="http://localhost/sindicatodosestagios/filiado/listar" method="post" enctype = "multipart/form-data">
        <h3>Filtro</h3>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="flo_nome" placeholder="Digite o nome" >

        <div>
            <label>Grau de Parentesco</label>
            <select name="flo_data_nascimento">
                <option value=""></option>
                <option value="1">Janeiro</option>
                <option value="2">Fevereiro</option>
                <option value="2">Março</option>
                <option value="4">Abril</option>
                <option value="5">Maio</option>
                <option value="6">Junho</option>
                <option value="7">Julho</option>
                <option value="8">Agosto</option>
                <option value="9">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>

            </select>
        </div>

        <input type="submit" name="filtro" class="botao-filtrar" value="Filtrar"/>
    </form>

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
                    <?php if($bAparecerBotao): ?>
                    <th colspan="2">Ação</th>
                    <?php endif?>

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
                            <form action="http://localhost/sindicatodosestagios/dependente/listar" method="post">
                                <input type="hidden" name="flo_id" value="<?= $filiado->getIId() ?>">
                                <input type="submit" class="botao-dependentes" value="Visualizar dependentes">
                            </form>
                        </td>
                        <?php if($bAparecerBotao): ?>
                        <td>
                            <form action="http://localhost/sindicatodosestagios/filiado/editar" method="post">
                                <input type="hidden" name="flo_id" value="<?= $filiado->getIId() ?>">
                                <input type="submit" class="botao-editar" value="Editar">
                            </form>
                        </td>
                        <td>
                            <form action="http://localhost/sindicatodosestagios/filiado/deletar" method="post">
                                <input type="hidden" name="flo_id" value="<?= $filiado->getIId() ?>">
                                <input type="submit" class="botao-excluir" value="Excluir">
                            </form>
                        </td>
                        <?php endif?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>

    <?php if($bAparecerBotao): ?>
    <a class="botao-cadastrar-filiado" href="http://localhost/sindicatodosestagios/filiado/cadastrar">Cadastrar Novo Filiado</a>
    <?php endif?>

    <a class="botao-voltar-menu" href="http://localhost/sindicatodosestagios/usuario/menu">Voltar</a>
    <a class="botao-sair" href="http://localhost/sindicatodosestagios/usuario/logout">Sair</a>

</main>
</body>
</html>
