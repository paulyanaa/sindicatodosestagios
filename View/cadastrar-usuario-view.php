<?php

require_once '../Controller/UsuarioController.php';

$oUsuarioController = new UsuarioController();
$oUsuarioController->cadastrarUsuario();

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Usuário - Cadastro</title>
</head>
<body>
<main>
    <h1>Cadastro de Usuário</h1>

    <section class="container-form">
        <form method="post" enctype = "multipart/form-data">

            <label for="login">Login</label>
            <input type="text" id="login" name="login" placeholder="Digite o login" required>

            <label for="senha">Senha</label>
            <input type="text" id="senha" name="senha" placeholder="Digite a senha" required>

            <div class="container-radio">
                <div>
                    <label for="administrador">Administrador</label>
                    <input type="radio" id="administrador" name="tipo" value="administrador" >
                </div>
                <div>
                    <label for="comum">Comum</label>
                    <input type="radio" id="comum" name="tipo" value="comum" >
                </div>
            </div>

            <input type="submit" name="cadastro" class="botao-cadastrar" value="Cadastrar usuário"/>
        </form>
        <a class="botao-voltar" href="lista-usuarios-view.php">Voltar</a>
        <a class="botao-sair" href="logout.php">Sair</a>

    </section>
</main>

</body>
</html>