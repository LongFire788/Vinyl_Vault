<?php
    session_start();
    if(isset($_SESSION["login_usuario"]) && isset($_SESSION["senha_usuario"])){
        echo"<script language='javascript' type='text/javascript'>
            alert('Você ja esta logado em uma conta');window.location
            .href='index.php'</script>";
    }else{
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="cadastro.css">
    <title>Cadastro Vinyl Vault</title>
    <script src="cadastro.js"></script>
    <link rel="icon" href="image/icon/icone_01.jpg" type="image/png">

</head>
<body>
    <div class="login-page">
        <div class="form">
          <form class="register-form">
          </form>
          <form class="login-form" action="cadastrar_usuario.php" method="POST">
            <input type="text" placeholder="Nome" name="nome" id="nome"/>
            <input type="text" placeholder="Sobrenome" name="sobrenome" id="sobrenome"/>
            <input type="text" placeholder="Nome de usuario" name="user" id="user"/>
            <input type="text" placeholder="Idade" name="idade" id="idade" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
            <input type="text" placeholder="CPF" name="cpf" id="cpf" maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
            
            
            <span class="ls-label-text-prefix ls-ico-user"></span>

          <div>
            <input type="password" id="psw" name="psw" placeholder="Senha" title="" onkeypress="checkPassword()"  required>
            
            <p id="letter" class="invalid">Uma letra <b>minuscula</b></p>
            <p id="capital" class="invalid">Uma letra <b>maiuscula</b></p>
            <p id="number" class="invalid">Um <b>numero</b></p>
            <p id="length" class="invalid">Minimo <b>6 caracteres</b></p>


            <input type="email" placeholder="Email" name="email" id="email"/>
            <p class="p">Gênero:</p>
            <div class="radio"><input type="radio" class="checkbox" id="Masc" name="gen" value="M"><label class="checkbox">Masculino</label></div>
            <div class="radio"><input type="radio" class="checkbox" id="Fem" name="gen" value="F"><label class="checkbox">Feminino</label></div>
            <div class="radio"><input type="radio" class="checkbox" id="Out" name="gen" value="O"><label class="checkbox">Outro</label></div>


            <button onclick="TesteFinal()">Cadastre-se</button>
            <p class="message">Já registrado? <a href="login.php">Entre</a></p>
          </form>
        </div>
        <a href="index.php"><button class="button button1">Home</button></a>
      </div>
      

</body>
</html>
<?php
    }
?>