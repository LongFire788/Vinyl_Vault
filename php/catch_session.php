<?php

    function session(){
        require "db_connect";
        if(isset($_SESSION['login_usuario']) && isset($_SESSION['senha_usuario'])) {
            $email = $_SESSION['login_usuario'];
            $senha = $_SESSION['senha_usuario'];
            $query = "SELECT * FROM usuario WHERE email = "+$_SESSION['login_usuario']+" AND senha = "+$_SESSION['senha_usuario'];
            $result = mysqli_query($connect, $query);
            $array = mysqli_fetch_array($result);
            $usuario = $array['user'];
            
        }
    }
    function sessio_foto(){
        require "db_connect";
            if(isset($_SESSION['login_usuario']) && isset($_SESSION['senha_usuario'])) {
            $email = $_SESSION['login_usuario'];
            $senha = $_SESSION['senha_usuario'];
            $query = "SELECT * FROM usuario WHERE email = "+$_SESSION['login_usuario']+" AND senha = "+$_SESSION['senha_usuario'];
            $result = mysqli_query($connect, $query);
            $array = mysqli_fetch_array($result);
            $foto = $array['foto_perfil'];
                if($foto != "foto_padrao.png"){
                    echo '<img src="data:image/jpeg;base64,'. base64_encode($imageData) .'" alt="Foto de usuario" style="max-width: 500px;">';
                }else{
                        echo "<img href='Perfil.php' src='uploads/profile/".$image."' class='imgUser'  >";
                }
            }
    }
?>