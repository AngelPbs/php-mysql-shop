<?php
session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}


include_once("../conexao/conexao.php"); 

if (isset($_GET['id'])) {
    $encomenda_id = $_GET['id'];

    // Recuperar os detalhes da encomenda da tabela 'detalhes_encomenda' usando o ID
    $sql = "SELECT p.nome AS nome_produto, SUM(de.quantidade) AS quantidade_total, SUM(de.preco_total_produto) AS preco_total
            FROM detalhes_encomenda de
            INNER JOIN produtos p ON de.produto_id = p.id
            WHERE de.encomenda_id = $encomenda_id
            GROUP BY p.nome";

    $result = $conexao->query($sql);

}
$conexao->close();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalhes da Encomenda</title>
  <link rel="stylesheet" href="./css/detalhes.css">
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
  <table>
<?php
if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr><th>Produto</th><th>Quantidade Total</th><th>Preço Total</th></tr>";
  
  $totalQuantidade = 0;
  $totalPreco = 0;

  while ($row = $result->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $row["nome_produto"] . "</td>";
      echo "<td>" . $row["quantidade_total"] . "</td>";
      echo "<td>" . $row["preco_total"] . "</td>";
      echo "</tr>";

      $totalQuantidade += $row["quantidade_total"];
      $totalPreco += $row["preco_total"];
  }

  echo "<tr>";
  echo "<td><strong>Total Geral</strong></td>";
  echo "<td><strong>$totalQuantidade</strong></td>";
  echo "<td><strong>$totalPreco</strong></td>";
  echo "</tr>";

  echo "</table>";
} else {
  echo "Nenhuma encomenda encontrada.";
}
?>
  </table>
  <a href="encomendas.php">Voltar para a lista de encomendas</a>
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
    });
  </script>
</body>
</html>
