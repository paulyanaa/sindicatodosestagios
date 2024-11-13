<?php
require_once '../Config/SessaoHandler.php';

$oSessaoHandler = new SessaoHandler();
$oSessaoHandler->verificarSessao();

?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <title>Menu</title>
</head>
<body>
<main>

    <h1>Menu - Administrador</h1>

    <section class="container-buttons">
        <a class="botao-listar-usuario" href="lista-usuarios-view.php" >Usuários</a>
        <a class="botao-listar-filiado" href="lista-filiados-view.php" >Filiados</a>

        <a class="botao-sair" href="logout.php">Sair</a>

    </section>
</main>

</body>
</html>