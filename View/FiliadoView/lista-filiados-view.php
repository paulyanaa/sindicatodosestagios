<?php
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo AmbienteConfig::getUrl('View/css/styles.css')?>">
    <title>Filiados</title>
</head>
<body>
<main>

    <h1>Filiados Cadastrados</h1>

    <form action="<?php echo AmbienteConfig::getUrl('filiado/listar')?>" method="post" enctype = "multipart/form-data">
        <h3>Filtro</h3>
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="flo_nome" placeholder="Digite o nome" >

        <div>
            <label>Mês de nascimento</label>
            <select name="flo_data_nascimento">
                <option value="">Selecione</option>
                <option value="1" >Janeiro</option>
                <option value="2" >Fevereiro</option>
                <option value="3" >Março</option>
                <option value="4" >Abril</option>
                <option value="5" >Maio</option>
                <option value="6" >Junho</option>
                <option value="7" >Julho</option>
                <option value="8" >Agosto</option>
                <option value="9" >Setembro</option>
                <option value="10" >Outubro</option>
                <option value="11" >Novembro</option>
                <option value="12" >Dezembro</option>
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
                        <td><?php echo $filiado->getSNome() ?></td>
                        <td><?php echo $filiado->getSCpf() ?></td>
                        <td><?php echo $filiado->getSRg() ?></td>
                        <td><?php echo $filiado->getDataNascimentoFormatada()?></td>
                        <td><?php echo $filiado->getIIdade() ?></td>
                        <td><?php echo $filiado->getSEmpresa() ?></td>
                        <td><?php echo $filiado->getSCargo() ?></td>
                        <td><?php echo $filiado->getSSituacao() ?></td>
                        <td><?php echo $filiado->getSTelResidencial() ?></td>
                        <td><?php echo $filiado->getSTelCelular() ?></td>
                        <td><?php echo $filiado->getUltimaAtualizacaoFormatada() ?></td>
                        <td>

                            <a class="botao-dependentes" href="<?php echo AmbienteConfig::getUrl('dependente/listar')?>?flo_id=<?php echo $filiado->getIId() ?>">Visualizar Dependentes</a>

                        </td>
                        <?php if($bAparecerBotao): ?>
                        <td>
                            <form action="<?php echo AmbienteConfig::getUrl('filiado/editar')?>" method="post">
                                <input type="hidden" name="flo_id" value="<?php echo $filiado->getIId() ?>">
                                <input type="submit" class="botao-editar" value="Editar">
                            </form>
                        </td>
                        <td>
                            <form action="<?php echo AmbienteConfig::getUrl('filiado/deletar')?>" method="post">
                                <input type="hidden" name="flo_id" value="<?php echo $filiado->getIId() ?>">
                                <input type="submit" class="botao-excluir" value="Excluir">
                            </form>
                        </td>
                        <?php endif?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
        <a class="botao-primeira-pagina" href="?pagina=1">Primeira</a>

        <?php if($iPagina>1):?>
        <a class="botao-pagina-anterior" href="?pagina=<?php echo $iPagina - 1?>"><<</a>
        <?php endif;?>

        <?php echo $iPagina?>

        <?php if($iPagina<$iPaginas):?>
        <a class="botao-pagina-seguinte" href="?pagina=<?php echo $iPagina + 1?>">>></a>
        <?php endif;?>
        <a class="botao-ultima-pagina" href="?pagina=<?php echo $iPaginas?>">Última</a>

    </section>

    <?php if($bAparecerBotao): ?>
        <br><a class="botao-cadastrar-filiado" href="<?php echo AmbienteConfig::getUrl('filiado/cadastrar')?>">Cadastrar Novo Filiado</a><br>
    <?php endif?>

    <a class="botao-voltar-menu" href="<?php echo AmbienteConfig::getUrl('usuario/menu')?>">Voltar</a>
    <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>

</main>
</body>
</html>
