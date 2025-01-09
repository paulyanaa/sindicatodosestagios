<?php
use Moobi\SindicatoDosEstagios\Config\AmbienteConfig;
use Moobi\SindicatoDosEstagios\Model\Usuario\UsuarioModel;

    /**
     * @var array $loUsuariosAdmins
     * @var array $loUsuariosComuns
     * @var UsuarioModel $oAdmin
     * @var UsuarioModel $oComum
     */
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo AmbienteConfig::getUrl('View/css/styles.css')?>">
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
                <?php foreach($loUsuariosAdmins as $oAdmin):?>
                <tr>
                    <td><?= $oAdmin->getLogin() ?></td>
                    <td><?= $oAdmin->getTipo() ?></td>
                    <td>
                        <form action="<?php echo AmbienteConfig::getUrl('usuario/deletar')?>" method="post">
                            <input type="hidden" name="uso_id" value="<?php echo $oAdmin->getId() ?>">
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
                <?php foreach($loUsuariosComuns as $oComum):?>
                <tr>
                    <td><?php echo $oComum->getLogin()?></td>
                    <td><?php echo $oComum->getTipo() ?></td>
                    <td>
                        <form action="<?php echo AmbienteConfig::getUrl('usuario/deletar')?>" method="post">
                            <input type="hidden" name="uso_id" value="<?= $oComum->getId() ?>">
                            <input type="submit" class="botao-excluir" value="Excluir">
                        </form>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </section>
    <a class="botao-cadastrar-usuario" href="<?php echo AmbienteConfig::getUrl('usuario/cadastrar')?>">Cadastrar Novo Usuário</a>
    <a class="botao-voltar-menu" href="<?php echo AmbienteConfig::getUrl('usuario/menu')?>">Voltar</a>
    <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>
</main>
</body>
</html>
