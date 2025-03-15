<?php

require_once "php/db_connect.php";

$image = $_FILES['image']['name'];
$extension = substr($image,strlen($image)-4,strlen($image));
$allowed_extensions = array(".jpg","jpeg",".png",".gif");

if(in_array($extension, $allowed_extensions)){
    $imgnewfile = md5($image).time().$extension;
    move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/profile/".$imgnewfile);
    $query_select = "UPDATE usuario SET foto_perfil = '$imgnewfile'";
    $query = mysqli_query($connect, $query_select);
    if($query){
        echo"<script language='javascript' type='text/javascript'>
        alert('Foto enviada');window.location
        .href='perfil.php';</script>";
    }else{
        echo"<script language='javascript' type='text/javascript'>
        alert('Falha ao enviar arquivo');window.location
        .href='mudar_foto.php';</script>";
    }

}


?>