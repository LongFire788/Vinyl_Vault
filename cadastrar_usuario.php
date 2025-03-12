<?php
    require_once "php/db_connect.php";
    
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $user = $_POST['user'];
    $idade = $_POST['idade'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $c_senha = $_POST['c_psw'];
    $email = $_POST['emil'];
    $gen = $_POST['gen'];

    if($senha != $c_senha){
        echo "<script language='javascript' type='text/javascript'>
        alert('As senhas colocadas não são iguais');
        window.location.href='cadastro.php';
        </script>";
    }else{
        
    }
?>