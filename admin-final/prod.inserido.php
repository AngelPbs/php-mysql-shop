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
  <title> Produto inserido </title>
<link rel="stylesheet" href="./css/produtosnew.css">


<style>
  #content{
    text-align: center;
    color: orange;
  }
  h2{
    margin-top: 10%;
  }
  
  #link{
    text-decoration: none;
  font-size: 20px;
   font-weight: bold;
   color: darkred;
  }
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

<div id="content">

<h2> Produto inserido com sucesso</h2>
<h3> Voltar inserir outro produto?</h3> <a id="link" href="./produtos_new.php"> Aqui </a>
</div>
<script>

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