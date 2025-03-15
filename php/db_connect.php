<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "vinyl";
    $connect = mysqli_connect($servername,$username,$password,$db_name);

    if(mysqli_connect_error()){
        echo "Erro na conexão!";
    }
?>