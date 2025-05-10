<?php
require_once "php/db_connect.php";
require_once "php/catch_session.php";
session_start();

// Verifica se o usuário está logado
if(!isset($_SESSION['login_usuario']) || !isset($_SESSION['senha_usuario'])){
    header("Location: login.php");
    exit();
}

// Busca informações do usuário
$email = $_SESSION['login_usuario'];
$query = "SELECT * FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($connect, $query);
$usuario = mysqli_fetch_assoc($resultado);

// Processa atualização do perfil
$mensagem = "";
if(isset($_POST['atualizar_perfil'])) {
    $novo_nome = mysqli_real_escape_string($connect, $_POST['nome']);
    $nova_senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];
    
    // Verificação e atualização do nome
    if(!empty($novo_nome) && $novo_nome != $usuario['user']) {
        $query = "UPDATE usuario SET user = '$novo_nome' WHERE email = '$email'";
        mysqli_query($connect, $query);
        $mensagem .= "Nome atualizado com sucesso! ";
        $usuario['user'] = $novo_nome; // Atualiza o array para exibição imediata
    }
    
    // Verificação e atualização da senha
    if(!empty($nova_senha)) {
        if($nova_senha == $confirmar_senha) {
            // Verificando se você usa hash ou senha em texto puro (baseado no seu código)
            $nova_senha_db = $nova_senha; // Usando o mesmo formato que você usa atualmente
            $query = "UPDATE usuario SET senha = '$nova_senha_db' WHERE email = '$email'";
            mysqli_query($connect, $query);
            $mensagem .= "Senha atualizada com sucesso! ";
            // Atualiza a sessão com a nova senha
            $_SESSION['senha_usuario'] = $nova_senha_db;
        } else {
            $mensagem .= "As senhas não coincidem! ";
        }
    }
    
    // Upload de foto usando BLOB
    if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto'];
        $permitidos = ['image/jpeg', 'image/jpg', 'image/png'];
        
        if(in_array($foto['type'], $permitidos)) {
            // Lê o conteúdo do arquivo
            $imagem_temporaria = $foto['tmp_name'];
            $imagem_conteudo = file_get_contents($imagem_temporaria);
            
            // Atualiza a imagem no banco de dados como BLOB
            $imagem_conteudo = mysqli_real_escape_string($connect, $imagem_conteudo);
            $query = "UPDATE usuario SET foto_perfil = '$imagem_conteudo' WHERE email = '$email'";
            if(mysqli_query($connect, $query)) {
                $mensagem .= "Foto atualizada com sucesso! ";
                $usuario['foto_perfil'] = $imagem_conteudo; // Atualiza o array para exibição imediata
            } else {
                $mensagem .= "Erro ao atualizar a foto no banco de dados. ";
            }
        } else {
            $mensagem .= "Tipo de arquivo não permitido. Use apenas JPG ou PNG. ";
        }
    }
}

// Busca notificações do usuário (usando o email do usuário em vez do id)
$email_usuario = $usuario['email'];

// Verificando se a tabela notificacoes existe
$check_table = mysqli_query($connect, "SHOW TABLES LIKE 'notificacoes'");
$tabela_existe = mysqli_num_rows($check_table) > 0;

$resultado_notificacoes = false;
if ($tabela_existe) {
    // Se a tabela existir, tentamos buscar as notificações
    $query_notificacoes = "SELECT * FROM notificacoes WHERE email_usuario = '$email_usuario' ORDER BY data DESC LIMIT 5";
    $resultado_notificacoes = mysqli_query($connect, $query_notificacoes);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Vinyl Vault</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="configuracoes.css">
    <link rel="icon" href="image/icon/icone_01.jpg" type="image/png">
</head>
<body>
    <div class="header">
        <p class="header_child">Olá <?php echo session() ?></p>
        <div class="header-right">
            <a href="configuracoes.php"><?php echo session_foto() ?></a>
            <a href="logout.php"><button class="botao_header">Sair</button></a>
        </div>
    </div>

    <div class="container">
        <h1>Configurações da Conta</h1>
        
        <?php if(!empty($mensagem)): ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        
        <div class="config-container">
            <div class="foto-perfil">
                <h2>Foto de Perfil</h2>
                <?php 
                if(!empty($usuario['foto_perfil'])) {
                    echo '<img src="data:image/jpeg;base64,'. base64_encode($usuario['foto_perfil']) .'" alt="Foto de Perfil" class="imgUser">';
                } else {
                    echo "<img src='image/perfil/foto_padrao.png' alt='Foto de Perfil' class='imgUser'>";
                }
                ?>
            </div>
            
            <div class="dados-perfil">
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nome">Usuario</label>
                        <input type="text" id="nome" name="nome" value="<?php echo $usuario['user']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" value="<?php echo $usuario['email']; ?>" readonly>
                        <p class="info">O email não pode ser alterado</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="foto">Alterar Foto</label>
                        <input type="file" id="foto" name="foto">
                    </div>
                    
                    <div class="form-group">
                        <label for="senha">Nova Senha</label>
                        <input type="password" id="senha" name="senha" placeholder="Deixe em branco para manter a senha atual">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirmar_senha">Confirmar Nova Senha</label>
                        <input type="password" id="confirmar_senha" name="confirmar_senha">
                    </div>
                    
                    <button type="submit" name="atualizar_perfil" class="btn-atualizar">Atualizar Perfil</button>
                </form>
            </div>
        </div>
        
        <div class="notificacoes">
            <h2>Notificações Recentes</h2>
            <div class="lista-notificacoes">
                <?php 
                if($tabela_existe && $resultado_notificacoes && mysqli_num_rows($resultado_notificacoes) > 0) {
                    while($notificacao = mysqli_fetch_assoc($resultado_notificacoes)) {
                        echo "<div class='notificacao'>";
                        echo "<div class='notificacao-cabecalho'>";
                        echo "<h3>{$notificacao['titulo']}</h3>";
                        
                        // Verifica se a coluna data existe antes de formatá-la
                        if(isset($notificacao['data'])) {
                            echo "<span class='data'>" . date('d/m/Y H:i', strtotime($notificacao['data'])) . "</span>";
                        }
                        
                        echo "</div>";
                        echo "<p>{$notificacao['mensagem']}</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Você não possui notificações recentes.</p>";
                }
                ?>
            </div>
        </div>
        
        <div class="acoes">
            <h2>Ações da Conta</h2>
            <a href="index.php" class="btn-voltar">Voltar para a Página Inicial</a>
            <a href="coleção.php" class="btn-colecao">Minha Coleção de Vinis</a>
        </div>
    </div>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Vinyl Vault - Todos os direitos reservados</p>
    </footer>
</body>
</html>