<?php
require_once "php/db_connect.php";
// loga o usuario validando se existe o usuario e caso exista coloca uma seession e colca as informações de login como variaveis
$email = $_POST['email'];
$password = $_POST['senha'];
$query_select = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$password'";
$db = mysqli_select_db($connect, 'inj');
$verifica = mysqli_query($connect, $query_select);
if (mysqli_num_rows($verifica)<=0){
    echo"<script language='javascript' type='text/javascript'>
    alert('Login e/ou senha incorretos');window.location.href='login.php';</script>";
    die();
}else{
    session_start();
    $_SESSION['login_usuario'] = $email;	
	$_SESSION['senha_usuario'] = $password;
    setcookie("login",$email);
    header("Location:index.php");
    }
?>