<?php


session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}


include_once("../conexao/conexao.php"); 

$sql = "SELECT * FROM produtos";
$stmt = $conexao->prepare($sql);

if ($stmt === false) {
    die("Preparação da consulta falhou " );
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="./css/produtos.css">
    
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


    <?php if ($result->num_rows > 0) : ?>
        <table>
            <tr class="tr-hide">
                <th>ID</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Imagem</th>
                <th>Ação</th>
            </tr>
            <?php while($row = $result->fetch_assoc()) : ?>
                <tr >
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["nome"]; ?></td>
                    <td><?php echo $row["quantidade"]; ?></td>
                    <td><?php echo $row["preco"]; ?></td>
                    <td><img src="<?php echo $row["imagem"]; ?>" alt="Imagem do Produto" width="50"></td>
                    <td><a id="edit" href="editar_produto.php?id=<?php echo $row["id"]; ?>">Editar</a>
                    <a id="delete" href="eliminar_produto.php?id=<?php echo $row["id"]; ?>">Eliminar</a></td>

                </tr>
            <?php endwhile; ?>
        </table>
    <?php else : ?>
        <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
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
