<?php

session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}


include_once("../conexao/conexao.php"); 

?>


<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inserir novos produtos</title>
<link rel="stylesheet" href="./css/produtosnew.css">
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

<form action="./inserir_produto.php" method="post" enctype="multipart/form-data">
    <p>Nome do Produto:</p>
    <input type="text" name="nome" required><br>
    <p>Quantidade Disponível:</p>
    <input type="number" name="quantidade" required><br>
    <p>Preço por Unidade:</p>
    <input type="number" step="0.01" name="preco" required><br>
    <p>Imagem do Produto:</p>
    <input type="file" name="imagem" accept="image/*" required><br>
    <input type="submit" value="Inserir Produto">
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