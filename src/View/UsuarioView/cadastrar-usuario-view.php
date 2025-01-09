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
    <title>Usuário - Cadastro</title>
</head>
<body>
<main>
    <h1>Cadastro de Usuário</h1>
    <section class="container-form">
        <form action="<?php echo AmbienteConfig::getUrl('usuario/cadastrarUsuario')?>" method="post" enctype = "multipart/form-data">

            <label for="login">Login</label>
            <input type="text" id="login" name="uso_login" placeholder="Digite o login" required>

            <label for="senha">Senha</label>
            <input type="text" id="senha" name="uso_senha" placeholder="Digite a senha" required>

            <div class="container-radio">
                <div>
                    <label for="administrador">Administrador</label>
                    <input type="radio" id="administrador" name="uso_tipo" value="administrador" >
                </div>
                <div>
                    <label for="comum">Comum</label>
                    <input type="radio" id="comum" name="uso_tipo" value="comum" >
                </div>
            </div>

            <input type="submit" name="cadastro" class="botao-cadastrar" value="Cadastrar usuário"/>
        </form>
        <a class="botao-voltar-menu" href="<?php echo AmbienteConfig::getUrl('usuario/listar')?>">Voltar</a>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>
    </section>
</main>
</body>
</html>