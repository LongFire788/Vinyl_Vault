<?php
    require "php/db_connect.php";
    require "php/querry.php";
    
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $user = $_POST['user'];
    $idade = $_POST['idade'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['psw'];
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
        $array1 = query($query_select);
        
        $query_select2 = "SELECT * FROM usuario WHERE cpf = '$cpf'";
        $array2 = query($query_select2);

        $query_select3 = "SELECT * FROM usuario";
        $array3 = query($query_select3);


        if($array1 == '' || $array1 == null && $array2 == null || $array2 == ''){
            if($array3 == ''|| $array3 == null){
                $tipo = 1;
            }else{
                $tipo = 0;
            }
            $query = "INSERT INTO usuario (nome, sobrenome, user, idade, cpf, foto_perfil, email, senha, genero, adm) VALUES ('$nome', '$sobrenome', '$user', '$idade', '$cpf', '$imagem', '$email', '$senha', '$gen', '$tipo')";
            $insert = mysqli_query($connect, $query);

            if($insert){
                echo"<script language='javascript' type='text/javascript'>
                alert('Cadastrado com sucesso!');
                window.location.href='login.php'</script>";
            }else{
                echo"<script language='javascript' type='text/javascript'>
                alert('Não foi possível cadastrar esse usuário');
                window.location.href='cadastro.php'</script>";
            }
        }

    }
?>