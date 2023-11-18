<?php
session_start();

if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel="stylesheet" href="./css/indexcss.css">
    
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
          
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
    <div class="background" id="background">
    <h1>Bem-vindo ao Painel de Administração</h1>
    <p>Olá, <?php echo $_SESSION['nome']; ?>!</p>
    
    </div>
<script>
  document.querySelector('.menu-toggle').addEventListener('click', function() {
    document.querySelector('.menu').classList.toggle('active');
    const backgroundDiv = document.getElementById('background');
        if (document.querySelector('.menu').classList.contains('active')) {
            backgroundDiv.style.transform = 'translateY(100px)';
        } else {
            backgroundDiv.style.transform = 'none'; 
        }
    });
</script>
</body>
</html>
