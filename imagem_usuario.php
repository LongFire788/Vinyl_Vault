<?php

if(isset($_SESSION['login_usuario']) && isset($_SESSION['senha_usuario'])) {
    $email = $_SESSION['login_usuario'];
    $senha = $_SESSION['senha_usuario'];
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $image = $_FILES['image']['tmp_name'];
        $imgContent = file_get_contents($image);
        $img = mysqli_real_escape_string($connection, $imgContent);

        // Insert image data into database as BLOB
        $sql = "UPDATE usuarios SET foto_perfil = '$img' WHERE email = '$email' AND senha = '$senha'";
        $result = mysqli_query($connect, $sql);
        if ($result) {
            $current_id = mysqli_insert_id($connection);  // Get the last inserted ID
        } else {
            die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($connection));  // Display the error if query fails
        }

        if ($current_id) {
            echo "A imagem foi alterada.";
        } else {
            echo "O upload a imagem falhou.";
        }
    } else {
        echo "Selecione uma imagem para fazer upload.";
    }
}else{
    echo "Você não esta logado";
}
?>