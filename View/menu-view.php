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
    <title>Menu</title>
</head>
<body>
<main>
    <h1>Menu</h1>
    <section class="container-buttons">
        <?php if($bAparecerBotao): ?>
        <a class="botao-listar-usuario" href="<?php echo AmbienteConfig::getUrl('usuario/listar')?>" >Usuários</a><br>
        <?php endif;?>
        <a class="botao-listar-filiado" href="<?php echo AmbienteConfig::getUrl('filiado/listar')?>" >Filiados</a><br>
        <a class="botao-sair" href="<?php echo AmbienteConfig::getUrl('usuario/logout')?>">Sair</a>
    </section>
</main>
</body>
</html>