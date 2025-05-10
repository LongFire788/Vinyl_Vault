<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="login.css">
    <title>Login</title>
    <link rel="icon" href="image/icon/icone_01.jpg" type="image/png">

</head>
<body>
    <div class="bg-img">
    <div class="login-page">
        <div class="form">
          <form class="register-form" >
            <button>create</button>
            <p class="message">Ja registrado? <a href="#">Entre</a></p>
          </form>
          <form class="login-form" action="login_usuario.php" method="post">
            <input type="email" placeholder="Email" name="email" id="email"/>
            <input type="password" placeholder="Senha" name="senha" id="senha"/>
            <button>Entre</button>
            <p class="message">Não registrado? <a href="cadastro.php">Crie uma conta</a></p>
          </form>
        </div>
        <a href="index.php"><button class="button button1">Voltar</button></a>
      </div>
      </div>
</body>
</html>