<?php


//     error_reporting(E_ALL);
//     ini_set('display_errors', 1);


include_once("../conexao/conexao.php"); 

//  Dados do formulário
$nome = $_POST['nome'];
$senha = $_POST['senha'];

// Consultar o banco de dados para verificar as informações
$query = "SELECT * FROM admins WHERE nome = ? AND senha = ? AND role = 'admin'";
$stmt = $conexao->prepare($query);
$stmt->bind_param("ss", $nome, $senha);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1) {
  // Autenticação bem-sucedida
  session_start();
  $_SESSION['nome'] = $nome;
  $_SESSION['role'] = 'admin';
  echo "Successful login. Redirecting...";
  header("Location:./index.php"); // Redirecionar para a página do painel de controle
  exit(); 
} else {
  // Autenticação falhou
  header("Location: admin.error.php"); // Redirecionar de volta à página de login com um erro
  exit();
}
?>
