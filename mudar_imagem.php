<!DOCTYPE html>
<html lang="pt-br">
<head>
<?php
    session_start();
    require_once "php/db_connect.php";

    ?>
    <title>Mudar foto</title>
    <link rel="stylesheet" href="change.css">
</head>
<body>

<div class="bg-img">
    <div class="login-page">
        <div class="form">
          <form class="register-form" >
            <button>create</button>
            <p class="message">Ja registrado? <a href="#">Entre</a></p>
          </form>
          <form class="login-form" action="imagem_usuario.php" method="POST" enctype="multipart/form-data">
          <p class="text">Insira a foto</p>
          <input type="file" name="image">
            <button>Salvar</button>
          </form>
        </div>
        <a href="perfil.php"><button class="button button1">Voltar</button></a>
      </div>
      </div>
</body>
</html>