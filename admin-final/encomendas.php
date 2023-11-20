<?php
session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}

include_once("../conexao/conexao.php"); 



$sql = "SELECT e.*, SUM(d.preco_total_produto) AS preco_total_encomenda FROM encomendas e
        LEFT JOIN detalhes_encomenda d ON e.encomenda_id = d.encomenda_id
        GROUP BY e.encomenda_id";

$stmt = $conexao->prepare($sql);

if ($stmt === false) {
    die("Preparação da consulta falhou ");
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
  <title>Encomendas</title>
 <link rel="stylesheet" href="./css/encomendas.css">
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
      <div class="table-container">
<?php

if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr class='table-row-head'><th>ID</th><th>Cliente</th><th>Data de Nascimento</th><th>Morada</th><th>Preço Total</th><th>Ação</th></tr>";
  while($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td><a href='detalhes_encomenda.php?id=" . $row["encomenda_id"] . "'>" . $row["encomenda_id"] . "</a></td>";
      echo "<td>" . $row["nome_cliente"] . "</td>";
      echo "<td>" . $row["data_nascimento_cliente"] . "</td>";
      echo "<td>" . $row["morada_cliente"] . "</td>";
      echo "<td>" . $row["preco_total_encomenda"] ."€". "</td>";
      
      echo "<td><a href='javascript:void(0);' class='eliminar-encomenda' data-id='" . $row["encomenda_id"] . "'>Eliminar</a></td>";
      echo "</tr>";
  }
  echo "</table>";
} else {
  echo "Nenhuma encomenda encontrada.";
}
?>
</div>
</div>

<script>
  // JavaScript para tratar a exclusão de encomendas
  const linksEliminar = document.querySelectorAll('.eliminar-encomenda');
  
  linksEliminar.forEach(link => {
      link.addEventListener('click', function() {
          const encomendaID = this.getAttribute('data-id');
          const confirmacao = confirm("Tem certeza de que deseja excluir esta encomenda?");
          
          if (confirmacao) {
              window.location.href = `eliminar_encomenda.php?id=${encomendaID}`;
          }
      });
  });


  document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('.menu').classList.toggle('active');
    const backgroundDiv = document.getElementById('content');
        if (document.querySelector('.menu').classList.contains('active')) {
            backgroundDiv.style.transform = 'translateY(100px)';
        } else {
            backgroundDiv.style.transform = 'none'; // Volta à posição original
        }
    });
</script>
</body>
</html>