<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once "conectar.php";

$produtos = ['Lanches' => [], 'Marmitas' => []];
$resultado = $conn->query("SELECT id, nome, preco, imagem, categoria FROM produtos ORDER BY id");
while ($p = $resultado->fetch_assoc()) {
    $produtos[$p['categoria']][] = $p;
}

function exibirProdutos($lista) {
    foreach ($lista as $p) {
        $nome  = htmlspecialchars($p['nome'], ENT_QUOTES, "UTF-8");
        $img   = htmlspecialchars($p['imagem'], ENT_QUOTES, "UTF-8");
        $preco = number_format($p['preco'], 2, ',', '.');
        
        $href  = ($p['nome'] === 'Hambúrguer') ? ' href="produto.php"' : '';
        echo "
                <fieldset class=\"fieldanuncio\">
                    <a{$href} class=\"botaoanuncios\" data-id=\"{$p['id']}\" data-nome=\"{$nome}\" data-preco=\"{$p['preco']}\">
                    <img src=\"imagens/{$img}\" alt=\"Imagem {$nome}\" class=\"imagensanuncios\">{$nome}<br>
                    <strong>R\${$preco}</strong>
                    </a>
                </fieldset>
";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Web</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <fieldset class="fieldheader">
            <div>
                <a href="menu.php" class="botaoinicio">
                    <img src="imagens/delivery-web.png" alt="Logo Delivery Web" class="logo">
                    <h1>Delivery <br> Web</h1>
                </a>
            </div>
            <div class="busca">
                <div class="pesquisa">
                    <input type="text" id="buscar" placeholder="Digite para buscar..." autocomplete="off">
                    <div id="sugestoes" class="sugestoes"></div>
                </div>
            </div>
            <div>
                <form action="<?= isset($_SESSION["usuario_id"]) ? "logout.php" : "login.php" ?>">
                    <?php if (isset($_SESSION["usuario_login"])): ?>
                        <span class="usuario-logado">Olá, <?= htmlspecialchars($_SESSION["usuario_login"], ENT_QUOTES, "UTF-8") ?></span>
                    <?php endif; ?>
                    <input type="submit" class="botaologin" name="botao" id="botaologin" value="<?= isset($_SESSION["usuario_id"]) ? "Sair" : "Entrar" ?>">
                </form>
            </div>
            <div>
                <form action="carrinho.php">
                    <button type="submit" class="botaocarrinho">
                        <img src="imagens/carrinho.png" alt="Icone carrinho" class="iconecarrinho">
                    </button>
                </form>     
            </div>
        </fieldset>
    </header>

    <div class="principal">
        <div class="anuncios">
            <div class="anuncioslanches">
                <h2>Lanches</h2>
                <?php exibirProdutos($produtos['Lanches']); ?>
            </div>

            <div class="anunciosmarmitas">
                <h2>Marmitas</h2>
                <?php exibirProdutos($produtos['Marmitas']); ?>
            </div>
        </div>
        <form action="avaliacoes.php" id="paraavaliacao">
            <p>Deseja avaliar algum produto?</p> <br>
            <input type="submit" value="Avaliar" class="botao">
        </form>
    </div>
    <footer>
        <fieldset class="fieldfooter">
            <p>© Copyright 2026 - Todos os direitos abertos Henrique Gama e Luisa Blankenburg</p>
            <input type="submit" value="Termos e condições de uso" class="botaofooter">
            <input type="submit" value="Privacidade" class="botaofooter">
            <input type="submit" value="Contato" class="botaofooter">
        </fieldset>
    </footer>

    <script>
        var busca = document.getElementById("buscar");
        var elementosAnuncios = document.querySelectorAll('.botaoanuncios');
        var opcoes = Array.from(elementosAnuncios).map(item => item.getAttribute('data-nome'));
        var sugestoes = document.getElementById("sugestoes");

        busca.addEventListener("input", function() {
            var valor = this.value.toLowerCase().trim();
            sugestoes.innerHTML = "";
            var filtrados = opcoes.filter(item => item.toLowerCase().includes(valor));

            filtrados.forEach(item => {
                const div = document.createElement("div");
                div.classList.add("sugestoes-item");
                div.textContent = item;

                div.addEventListener("click", () => {
                    busca.value = item;
                    sugestoes.innerHTML = "";
                });
                sugestoes.appendChild(div);
            });
        });
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".pesquisa")) sugestoes.innerHTML = "";
        });

    </script>
</body>
</html>