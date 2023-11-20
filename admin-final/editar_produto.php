<?php
session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}


include_once("../conexao/conexao.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];

    // Upload da nova imagem
    $novaImagem = $_FILES["imagem"]["name"];
    $imagemTemporaria = $_FILES["imagem"]["tmp_name"];

    // Atualização da imagem no banco de dados, se uma nova imagem for fornecida
    if (!empty($novaImagem)) {
        $caminhoDestino = "caminho/para/pasta/imagens/" . $novaImagem;
        move_uploaded_file($imagemTemporaria, $caminhoDestino);

        // Atualizar o campo "imagem" no banco de dados
        $sql = "UPDATE produtos SET nome='$nome', quantidade='$quantidade', preco='$preco', imagem='$novaImagem' WHERE id='$id'";
    } else {
        $sql = "UPDATE produtos SET nome='$nome', quantidade='$quantidade', preco='$preco' WHERE id='$id'";
    }

    if ($conexao->query($sql) === TRUE) {
        header("Location: produtos.php");
        exit();
    } else {
        echo "Erro ao atualizar produto ";
    }
} elseif (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM produtos WHERE id='$id'";
    $result = $conexao->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Produto não encontrado.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="./css/editar.prod.css">
    <style>
 </style>
</head>
<body>
<nav>
    <div class="nav-container">
        <div class="logo">
            <img src="../imagens/Escola-Profissional-MasterD-removebg-preview.png" alt="Logo">
        </div>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <ul class="menu">
            <li><a href="encomendas.php">Encomendas</a></li>
            <li><a href="produtos_new.php">Adicionar Produtos</a></li>
            <li><a href="produtos.php">Produtos</a></li>
            <li><a href="index.php">Voltar</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>


    <div class="content" id="content">

    <h1>Editar Produto</h1>

    <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
            <p>Nome do Produto:</p>
            <input type="text" name="nome" value="<?php echo $row["nome"]; ?>" required><br>
            <p>Quantidade Disponível:</p>
            <input type="number" name="quantidade" value="<?php echo $row["quantidade"]; ?>" required><br>
            <p>Preço por Unidade:</p>
            <input type="number" step="0.01" name="preco" value="<?php echo $row["preco"]; ?>" required><br>
            <p>Imagem do Produto:</p>
            <input type="file" name="imagem"><br>
            <input type="submit" value="Salvar Alterações">
        </form>
    </div>

    <script>
            // Abrir o menu mobile e descer a div "Content" para não ficar por trás do menu

  document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('.menu').classList.toggle('active');
    const backgroundDiv = document.getElementById('content');
        if (document.querySelector('.menu').classList.contains('active')) {
            backgroundDiv.style.transform = 'translateY(100px)';
        } else {
            backgroundDiv.style.transform = 'none'; // Volta à posição original
        }
    });</script>
</body>
</html>
