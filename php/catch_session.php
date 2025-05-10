<?php

    function session(){
        require "db_connect.php";
        if(isset($_SESSION['login_usuario']) && isset($_SESSION['senha_usuario'])) {
            $email = $_SESSION['login_usuario'];
            $senha = $_SESSION['senha_usuario'];
            $query = "SELECT * FROM usuario WHERE email = '".$_SESSION['login_usuario']."' AND senha = '".$_SESSION['senha_usuario']."'";
            $result = mysqli_query($connect, $query);
            $array = mysqli_fetch_array($result);
            $usuario = $array['user'];
            return $usuario;
        }
    }
    function session_foto(){
        require "db_connect.php";
            if(isset($_SESSION['login_usuario']) && isset($_SESSION['senha_usuario'])) {
            $email = $_SESSION['login_usuario'];
            $senha = $_SESSION['senha_usuario'];
            $query = "SELECT * FROM usuario WHERE email = '".$_SESSION['login_usuario']."' AND senha = '".$_SESSION['senha_usuario']."'";
            $result = mysqli_query($connect, $query);
            $array = mysqli_fetch_array($result);
            $foto = $array['foto_perfil'];
                if($foto != null && $foto != '' && $foto != NULL){
                    echo '<img src="data:image/jpeg;base64,'. base64_encode($foto) .'" alt="Foto de usuario" class="imgUser">';
                }else{
                        echo "<img href='Perfil.php' src='image/perfil/foto_padrao.png' class='imgUser'>";
                }
            }
    }
?>