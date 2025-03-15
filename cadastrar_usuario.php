<?php
    require_once "php/db_connect.php";
    
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $user = $_POST['user'];
    $idade = $_POST['idade'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $c_senha = $_POST['c_psw'];
    $email = $_POST['email'];
    $gen = $_POST['gen'];
    $imagem = "foto_padrao.png";

    if($senha != $c_senha){
        echo "<script language='javascript' type='text/javascript'>
        alert('As senhas colocadas não são iguais');
        window.location.href='cadastro.php';
        </script>";
    }else{
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
            $query_select = "SELECT * FROM, email WHERE email = '$email'";
            $query_select2 = "SELECT * FROM cpf WHERE cpf = '$cpf'";
            $select = mysqli_query($connect, $query_select);
            $select2 = mysqli_query($connect, $query_select2);
            $array = mysqli_fetch_array($select, MYSQLI_ASSOC);
            $array2 = mysqli_fetch_array($select2, MYSQLI_ASSOC);
            if($array == '' || $array == null){
                $query = "INSERT INTO usuario (nome, sobrenome, user, idade, cpf, foto perfil, email, senha, genero) VALUES ('$nome', '$sobrenome', '$user', '$idade', '$cpf', '$imagem', '$email', '$senha', '$gen'";
            }

        }
    }
?>