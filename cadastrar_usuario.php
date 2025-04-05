<?php
    require_once "php/db_connect.php";
    require "php/querry.php";
    
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $user = $_POST['user'];
    $idade = $_POST['idade'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $gen = $_POST['gen'];
    $imagem = "foto_padrao.png";

    if($email == '' || $email == null){
        echo "<script language='javascript' type='text/javascript'>
        alert('Insira um email');
        window.location.href='cadastro.php';
        </script>";
    }else if($senha == '' || $senha == null){
        echo "<script language='javascript' type='text/javascript'>
        alert('Insira uma senha');
        window.location.href='cadastro.php';
        </script>";
    }else if($cpf == '' || $cpf == null){
        echo "<script language='javascript' type='text/javascript'>
        alert('Para criar uma conta é necessario um CPF');
        window.location.href='cadastro.php';
        </script>";
    }else{
        $query_select = "SELECT * FROM usuario WHERE email = '$email'";
        query($query_select);
        $array1 = $array;
        
        $query_select2 = "SELECT * FROM usuario WHERE cpf = '$cpf'";
        query($query_select2);
        $array2 = $array;

        $query_select3 = "SELECT * FROM usuario";
        query($query_select3);
        $array3 = $array;

        if($array1 == '' || $array1 == null && $array2 == null || $array2 == ''){
            if($array3 == ''|| $array3 == null){
                $tipo = 1;
            }else{
                $tipo = 0;
            }
            $query = "INSERT INTO usuario (nome, sobrenome, user, idade, cpf, foto perfil, email, senha, genero, adm) VALUES ('$nome', '$sobrenome', '$user', '$idade', '$cpf', '$imagem', '$email', '$senha', '$gen', '$$tipo'";
        }

    }
?>