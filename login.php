<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "conectar.php";

$erro = "";
$mensagemSucesso = $_SESSION["mensagem_sucesso"] ?? "";
unset($_SESSION["mensagem_sucesso"]);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = trim($_POST["login"] ?? "");
    $senha = $_POST["senha"] ?? "";

    $stmt = $conn->prepare(
        "SELECT cpf, nome, login, senha FROM usuarios WHERE login = ?"
    );
    $stmt->bind_param("s", $login);
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($senha, $usuario["senha"])) {
        
        session_regenerate_id(true);

        $_SESSION["usuario_id"] = $usuario["cpf"];
        $_SESSION["usuario_nome"] = $usuario["nome"];
        $_SESSION["usuario_login"] = $usuario["login"];
        $_SESSION["mensagem_sucesso"] = "Login realizado com sucesso!";
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit;
    } else {
        $erro = "Login ou senha incorretos.";
    }

    $stmt->close();
    $conn->close();
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
    <script src="scripts.js" defer></script>
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
                <form action="#">
                    <label for="buscar"></label>
                    <input type="text" placeholder="  Buscar produtos..." id="buscar" name="busca">
                </form>
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
    <div class="divmeio">
        <fieldset class="fieldlogin">
           <h2>Tela de login</h2>
           <?php if ($erro !== ""): ?>
            <p role="alert">
                <?= htmlspecialchars($erro, ENT_QUOTES, "UTF-8") ?>
            </p>
            <?php endif; ?>
           <form action="login.php" method="post">
                <label for="login">Login:</label> 
                <input type="text" id="login" name="login" required> <br>
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
                <button type="submit" value="Enviar" class="botao" onclick="return verificarDados('login')">Enviar</button>
                <button type="reset" value="Apagar" class="botao">Apagar</button>
                <p id="escolhercadastro">Não tem conta? <a href="cadastro.php">Clique aqui</a></p>
            </form>
            <div id="modal" class="modal-fundo" data-redirect="<?= $mensagemSucesso !== "" ? "menu.php" : "" ?>" style="<?= $mensagemSucesso !== "" ? "display: flex;" : "" ?>">
                <div class="modal-conteudo" role="alertdialog" aria-modal="true" aria-labelledby="titulo-aviso">
                    <h2 id="titulo-aviso">Aviso</h2>
                    <p id="avisoDados" class="<?= $mensagemSucesso !== "" ? "aviso-sucesso" : "" ?>"><?= htmlspecialchars($mensagemSucesso, ENT_QUOTES, "UTF-8") ?></p><br>
                    <button id="fechar" type="button" class="botao" onclick="fecharAviso()">Fechar</button>
                </div>
            </div>
        </fieldset>
    </div>
    <footer>
        <fieldset class="fieldfooter">
            <p>© Copyright 2026 - Todos os direitos abertos Henrique Gama e Luisa Blankenburg</p>
            <input type="submit" value="Termos e condições de uso" class="botaofooter">
            <input type="submit" value="Privacidade" class="botaofooter">
            <input type="submit" value="Contato" class="botaofooter">
        </fieldset>
    </footer>
</body>
</html>