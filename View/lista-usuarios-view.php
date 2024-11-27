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
    <title>Usuários</title>
</head>
<body>
<main>

    <h1>Usuários Cadastrados</h1>


    <section class="container-admins">
        <div>
            <h3>Usuários Administradores</h3>
        </div>
        <div class="container-usuarios-admins">
            <table>
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Tipo</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($aUsuariosAdmins as $admin):?>
                <tr>
                    <td><?= $admin->getSLogin() ?></td>
                    <td><?= $admin->getSTipo() ?></td>
                    <td>
                        <form action="http://localhost/sindicatodosestagios/usuario/deletar" method="post">
                            <input type="hidden" name="id" value="<?= $admin->getIId() ?>">
                            <input type="submit" class="botao-excluir" value="Excluir">
                        </form>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>
    <section class="container-comuns">
        <div>
            <h3>Usuários Comuns</h3>
        </div>
        <div class="container-usuarios-comuns">
            <table>
                <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Tipo</th>
                    <th>Ação</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($aUsuariosComuns as $comum):?>
                <tr>
                    <td><?= $comum->getSLogin()?></td>
                    <td><?= $comum->getSTipo() ?></td>
                    <td>
                        <form action="http://localhost/sindicatodosestagios/usuario/deletar" method="post">
                            <input type="hidden" name="id" value="<?= $comum->getIId() ?>">
                            <input type="submit" class="botao-excluir" value="Excluir">
                        </form>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>
    <a class="botao-cadastrar-usuario" href="http://localhost/sindicatodosestagios/usuario/cadastrar">Cadastrar Novo Usuário</a>
    <a class="botao-voltar-menu" href="http://localhost/sindicatodosestagios/usuario/menu">Voltar</a>
    <a class="botao-sair" href="http://localhost/sindicatodosestagios/usuario/logout">Sair</a>

</main>
</body>
</html>
