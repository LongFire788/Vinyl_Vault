<?php
require_once "php/db_connect.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vault</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="image/icon/icone_01.jpg" type="image/png">
</head>
<header>
    <div class="header">
        <?php
            if(isset($_SESSION['login_usuario']) && isset($_SESSION['senha_usuario'])){

        ?>
            <a href="logout.php"><button class="botao_header">Sair</button></a>

        <?php
            }else{
        ?>
            <a href="login.php"><button class="botao_header">Login</button></a>
            <a href="cadastro.php"><button class="botao_header">Cadastre-se</button></a>
        <?php
            }
        ?>

    </div>
</header>
<body>

</body>
</html>