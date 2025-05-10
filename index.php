<?php
require_once "php/db_connect.php";
require_once "php/catch_session.php";
session_start();

// Buscar categorias para o menu
$query_categorias = "SELECT DISTINCT categoria FROM produtos ORDER BY categoria";
$resultado_categorias = mysqli_query($connect, $query_categorias);

// Buscar vinis em destaque (os mais recentes ou melhor avaliados)
$query_destaque = "SELECT * FROM produtos WHERE destaque = 1 AND estoque > 0 ORDER BY id_produto DESC LIMIT 4";
$resultado_destaque = mysqli_query($connect, $query_destaque);

// Buscar novos lançamentos
$query_novos = "SELECT * FROM produtos WHERE estoque > 0 ORDER BY data_cadastro DESC LIMIT 8";
$resultado_novos = mysqli_query($connect, $query_novos);

// Buscar vinis mais vendidos
$query_populares = "SELECT p.*, COUNT(v.id_produto) as vendas 
                   FROM produtos p 
                   JOIN vendas v ON p.id_produto = v.id_produto 
                   WHERE p.estoque > 0 
                   GROUP BY p.id_produto 
                   ORDER BY vendas DESC 
                   LIMIT 8";
$resultado_populares = mysqli_query($connect, $query_populares);

// Verificar se as tabelas existem antes de executar as consultas
$check_table_produtos = mysqli_query($connect, "SHOW TABLES LIKE 'produtos'");
$produtos_existe = mysqli_num_rows($check_table_produtos) > 0;

$resultado_destaque = false;
$resultado_novos = false;
$resultado_populares = false;
$resultado_categorias = false;

if ($produtos_existe) {
    // Buscar categorias para o menu
    $query_categorias = "SELECT DISTINCT categoria FROM produtos ORDER BY categoria";
    $resultado_categorias = mysqli_query($connect, $query_categorias);

    // Buscar vinis em destaque (os mais recentes ou melhor avaliados)
    $query_destaque = "SELECT * FROM produtos WHERE estoque > 0 ORDER BY id_produto DESC LIMIT 4";
    $resultado_destaque = mysqli_query($connect, $query_destaque);

    // Buscar novos lançamentos
    $query_novos = "SELECT * FROM produtos WHERE estoque > 0 ORDER BY data_cadastro DESC LIMIT 8";
    $resultado_novos = mysqli_query($connect, $query_novos);

    // Buscar vinis mais vendidos
    $check_table_vendas = mysqli_query($connect, "SHOW TABLES LIKE 'vendas'");
    $vendas_existe = mysqli_num_rows($check_table_vendas) > 0;
    
    if ($vendas_existe) {
        $query_populares = "SELECT p.*, COUNT(v.id_produto) as vendas 
                           FROM produtos p 
                           JOIN vendas v ON p.id_produto = v.id_produto 
                           WHERE p.estoque > 0 
                           GROUP BY p.id_produto 
                           ORDER BY vendas DESC 
                           LIMIT 8";
        $resultado_populares = mysqli_query($connect, $query_populares);
    }
}

// Função para exibir estrelas de avaliação
function mostrar_estrelas($avaliacao) {
    $estrelas = round($avaliacao);
    $html = '<div class="avaliacao">';
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $estrelas) {
            $html .= '<span class="estrela-cheia">★</span>';
        } else {
            $html .= '<span class="estrela-vazia">☆</span>';
        }
    }
    
    $html .= '</div>';
    return $html;
}

// Função para formatar preço
function formatar_preco($preco) {
    return 'R$ ' . number_format($preco, 2, ',', '.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vinyl Vault - Marketplace de Discos de Vinil</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="image/icon/icone_01.jpg" type="image/png">
</head>
<body>
    <div class="header">
        <div class="header-left">
            <a href="index.php" class="logo">
                <span class="logo-texto">Vinyl Vault</span>
            </a>
            <div class="search-container">
                <form action="busca.php" method="GET">
                    <input type="text" name="q" placeholder="Buscar discos, artistas, gêneros..." class="search-input">
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <div class="header-right">
            <?php
                if(isset($_SESSION['login_usuario']) && isset($_SESSION['senha_usuario'])){
            ?>
                <a href="carrinho.php" class="carrinho-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-number">0</span>
                </a>
                <div class="user-menu">
                    <p class="header_child">Olá <?php echo session() ?></p>
                    <a href="configuracoes.php"><?php echo session_foto() ?></a>
                    <div class="dropdown-content">
                        <a href="meus_pedidos.php">Meus Pedidos</a>
                        <a href="minha_colecao.php">Minha Coleção</a>
                        <a href="configuracoes.php">Configurações</a>
                        <a href="logout.php">Sair</a>
                    </div>
                </div>
            <?php
                } else {
            ?>
                <a href="carrinho.php" class="carrinho-link">
                    <i class="fas fa-shopping-cart"></i>
                </a>
                <a href="login.php"><button class="botao_header">Login</button></a>
                <a href="cadastro.php"><button class="botao_header">Cadastre-se</button></a>
            <?php
                }
            ?>
        </div>
    </div>

    <nav class="categorias">
        <ul>
            <li><a href="produtos.php">Todos os Vinis</a></li>
            <?php 
            if ($resultado_categorias && mysqli_num_rows($resultado_categorias) > 0) {
                while ($categoria = mysqli_fetch_assoc($resultado_categorias)) {
                    echo '<li><a href="produtos.php?categoria=' . urlencode($categoria['categoria']) . '">' . $categoria['categoria'] . '</a></li>';
                }
            } else {
                // Categorias padrão se não houver no banco
                $categorias_padrao = ['Rock', 'Jazz', 'Pop', 'Clássica', 'Samba', 'MPB', 'Hip Hop', 'Eletrônica'];
                foreach ($categorias_padrao as $cat) {
                    echo '<li><a href="produtos.php?categoria=' . urlencode($cat) . '">' . $cat . '</a></li>';
                }
            }
            ?>
            <li><a href="raridades.php">Raridades</a></li>
            <li><a href="promocoes.php">Promoções</a></li>
            <li><a href="trocas.php">Trocas</a></li>
        </ul>
    </nav>

    <div class="hero-section">
        <div class="hero-content">
            <h1>O Paraíso dos Colecionadores de Vinis</h1>
            <p>Compre, venda e troque discos de vinil em uma comunidade apaixonada pela qualidade analógica.</p>
            <div class="hero-buttons">
                <a href="produtos.php" class="btn-primary">Explorar Vinis</a>
                <a href="como-funciona.php" class="btn-secondary">Como Funciona</a>
            </div>
        </div>
    </div>

    <section class="destaque-slider">
        <h2>Em Destaque</h2>
        <div class="slider-container">
            <?php 
            if ($resultado_destaque && mysqli_num_rows($resultado_destaque) > 0) {
                while ($produto = mysqli_fetch_assoc($resultado_destaque)) {
                    $imagem = isset($produto['imagem']) ? 'data:image/jpeg;base64,'. base64_encode($produto['imagem']) : 'image/produtos/default-album.jpg';
                    ?>
                    <div class="destaque-item">
                        <div class="destaque-imagem">
                            <img src="<?php echo $imagem; ?>" alt="<?php echo $produto['titulo']; ?>">
                        </div>
                        <div class="destaque-info">
                            <h3><?php echo $produto['titulo']; ?></h3>
                            <p class="artista"><?php echo $produto['artista']; ?></p>
                            <div class="preco-avaliacao">
                                <span class="preco"><?php echo formatar_preco($produto['preco']); ?></span>
                                <?php 
                                if (isset($produto['avaliacao'])) {
                                    echo mostrar_estrelas($produto['avaliacao']); 
                                }
                                ?>
                            </div>
                            <a href="produto.php?id=<?php echo $produto['id_produto']; ?>" class="btn-detalhes">Ver Detalhes</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Produtos demo se não houver no banco
                for ($i = 1; $i <= 4; $i++) {
                    ?>
                    <div class="destaque-item">
                        <div class="destaque-imagem">
                            <img src="image/produtos/demo-<?php echo $i; ?>.jpg" alt="Álbum Demo">
                        </div>
                        <div class="destaque-info">
                            <h3>Álbum Clássico <?php echo $i; ?></h3>
                            <p class="artista">Artista Famoso</p>
                            <div class="preco-avaliacao">
                                <span class="preco">R$ 129,90</span>
                                <?php echo mostrar_estrelas(4); ?>
                            </div>
                            <a href="#" class="btn-detalhes">Ver Detalhes</a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </section>

    <section class="colecoes">
        <h2>Coleções para Explorar</h2>
        <div class="colecoes-grid">
            <a href="produtos.php?categoria=Rock" class="colecao-item rock">
                <div class="colecao-overlay">
                    <h3>Rock Clássico</h3>
                    <p>Pérolas do rock de todos os tempos</p>
                </div>
            </a>
            <a href="produtos.php?categoria=Jazz" class="colecao-item jazz">
                <div class="colecao-overlay">
                    <h3>Jazz</h3>
                    <p>Improvisos inesquecíveis em vinil</p>
                </div>
            </a>
            <a href="produtos.php?categoria=MPB" class="colecao-item mpb">
                <div class="colecao-overlay">
                    <h3>MPB</h3>
                    <p>O melhor da música brasileira</p>
                </div>
            </a>
            <a href="raridades.php" class="colecao-item raridades">
                <div class="colecao-overlay">
                    <h3>Raridades</h3>
                    <p>Itens exclusivos para colecionadores</p>
                </div>
            </a>
        </div>
    </section>

    <section class="novos-lancamentos">
        <h2>Novos Lançamentos</h2>
        <div class="produtos-grid">
            <?php 
            if ($resultado_novos && mysqli_num_rows($resultado_novos) > 0) {
                while ($produto = mysqli_fetch_assoc($resultado_novos)) {
                    $imagem = isset($produto['imagem']) ? 'data:image/jpeg;base64,'. base64_encode($produto['imagem']) : 'image/produtos/default-album.jpg';
                    ?>
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <img src="<?php echo $imagem; ?>" alt="<?php echo $produto['titulo']; ?>">
                            <div class="produto-acoes">
                                <a href="produto.php?id=<?php echo $produto['id_produto']; ?>" class="btn-ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="adicionar_carrinho.php?id=<?php echo $produto['id_produto']; ?>" class="btn-carrinho">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="adicionar_favorito.php?id=<?php echo $produto['id_produto']; ?>" class="btn-favorito">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="produto-info">
                            <h3><?php echo $produto['titulo']; ?></h3>
                            <p class="artista"><?php echo $produto['artista']; ?></p>
                            <p class="preco"><?php echo formatar_preco($produto['preco']); ?></p>
                            <?php 
                            if (isset($produto['avaliacao'])) {
                                echo mostrar_estrelas($produto['avaliacao']); 
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Produtos demo se não houver no banco
                for ($i = 1; $i <= 8; $i++) {
                    ?>
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <img src="image/produtos/demo-<?php echo $i % 4 + 1; ?>.jpg" alt="Álbum Demo">
                            <div class="produto-acoes">
                                <a href="#" class="btn-ver"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn-carrinho"><i class="fas fa-shopping-cart"></i></a>
                                <a href="#" class="btn-favorito"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="produto-info">
                            <h3>Disco Novo <?php echo $i; ?></h3>
                            <p class="artista">Artista Popular</p>
                            <p class="preco">R$ <?php echo rand(80, 200); ?>,90</p>
                            <?php echo mostrar_estrelas(rand(3, 5)); ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="center">
            <a href="produtos.php?ordem=novos" class="btn-ver-mais">Ver Mais Lançamentos</a>
        </div>
    </section>

    <section class="venda-seu-vinil">
        <div class="venda-content">
            <h2>Venda seus Vinis</h2>
            <p>Tem discos parados na prateleira? Transforme-os em dinheiro ou troque por outros itens para sua coleção.</p>
            <a href="vender.php" class="btn-primary">Anunciar Agora</a>
        </div>
    </section>

    <section class="mais-populares">
        <h2>Mais Populares</h2>
        <div class="produtos-grid">
            <?php 
            if ($resultado_populares && mysqli_num_rows($resultado_populares) > 0) {
                while ($produto = mysqli_fetch_assoc($resultado_populares)) {
                    $imagem = isset($produto['imagem']) ? 'data:image/jpeg;base64,'. base64_encode($produto['imagem']) : 'image/produtos/default-album.jpg';
                    ?>
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <img src="<?php echo $imagem; ?>" alt="<?php echo $produto['titulo']; ?>">
                            <div class="produto-acoes">
                                <a href="produto.php?id=<?php echo $produto['id_produto']; ?>" class="btn-ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="adicionar_carrinho.php?id=<?php echo $produto['id_produto']; ?>" class="btn-carrinho">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                                <a href="adicionar_favorito.php?id=<?php echo $produto['id_produto']; ?>" class="btn-favorito">
                                    <i class="far fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="produto-info">
                            <h3><?php echo $produto['titulo']; ?></h3>
                            <p class="artista"><?php echo $produto['artista']; ?></p>
                            <p class="preco"><?php echo formatar_preco($produto['preco']); ?></p>
                            <?php 
                            if (isset($produto['avaliacao'])) {
                                echo mostrar_estrelas($produto['avaliacao']); 
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Produtos demo se não houver no banco
                for ($i = 1; $i <= 8; $i++) {
                    ?>
                    <div class="produto-card">
                        <div class="produto-imagem">
                            <img src="image/produtos/demo-<?php echo ($i % 4) + 1; ?>.jpg" alt="Álbum Demo">
                            <div class="produto-acoes">
                                <a href="#" class="btn-ver"><i class="fas fa-eye"></i></a>
                                <a href="#" class="btn-carrinho"><i class="fas fa-shopping-cart"></i></a>
                                <a href="#" class="btn-favorito"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                        <div class="produto-info">
                            <h3>Clássico Popular <?php echo $i; ?></h3>
                            <p class="artista">Artista Renomado</p>
                            <p class="preco">R$ <?php echo rand(100, 300); ?>,90</p>
                            <?php echo mostrar_estrelas(rand(4, 5)); ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="center">
            <a href="produtos.php?ordem=populares" class="btn-ver-mais">Ver Mais Populares</a>
        </div>
    </section>

    <section class="beneficios">
        <h2>Por que escolher a Vinyl Vault?</h2>
        <div class="beneficios-grid">
            <div class="beneficio-item">
                <div class="beneficio-icone">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Segurança Garantida</h3>
                <p>Todas as transações são protegidas e garantimos a qualidade dos produtos.</p>
            </div>
            <div class="beneficio-item">
                <div class="beneficio-icone">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Entrega Rápida</h3>
                <p>Envios para todo o Brasil com embalagens especiais para discos.</p>
            </div>
            <div class="beneficio-item">
                <div class="beneficio-icone">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h3>Sistema de Trocas</h3>
                <p>Troque discos da sua coleção com outros colecionadores.</p>
            </div>
            <div class="beneficio-item">
                <div class="beneficio-icone">
                    <i class="fas fa-comments"></i>
                </div>
                <h3>Comunidade Ativa</h3>
                <p>Converse com outros apaixonados por música e vinil.</p>
            </div>
        </div>
    </section>

    <section class="newsletter">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <h2>Receba Novidades</h2>
                <p>Cadastre-se para receber notificações sobre novos discos e promoções.</p>
                <form action="newsletter.php" method="POST" class="newsletter-form">
                    <input type="email" name="email" placeholder="Seu melhor e-mail" required>
                    <button type="submit" class="btn-newsletter">Inscrever-se</button>
                </form>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-container">
            <div class="footer-col">
                <h3>Vinyl Vault</h3>
                <p>O marketplace de vinis que conecta colecionadores, amantes da música e vendedores em um só lugar.</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h3>Links Rápidos</h3>
                <ul>
                    <li><a href="produtos.php">Todos os Vinis</a></li>
                    <li><a href="raridades.php">Raridades</a></li>
                    <li><a href="trocas.php">Sistema de Trocas</a></li>
                    <li><a href="promocoes.php">Promoções</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Ajuda</h3>
                <ul>
                    <li><a href="como-funciona.php">Como Funciona</a></li>
                    <li><a href="faq.php">Perguntas Frequentes</a></li>
                    <li><a href="contato.php">Contato</a></li>
                    <li><a href="politica-privacidade.php">Política de Privacidade</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contato</h3>
                <ul class="contato-info">
                    <li><i class="fas fa-envelope"></i> contato@vinylvault.com.br</li>
                    <li><i class="fas fa-phone"></i> (11) 99999-9999</li>
                    <li><i class="fas fa-map-marker-alt"></i> São Paulo, SP - Brasil</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Vinyl Vault - Todos os direitos reservados</p>
        </div>
    </footer>

    <script>
        // Script simples para demonstração de carrossel
        document.addEventListener('DOMContentLoaded', function() {
            // Código para implementar funcionalidades JavaScript,
            // como carrossel, menu responsivo, etc.
        });
    </script>
</body>
</html>