<?php
session_start();

if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit();
}
//verificar o id e se é numerico
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    include_once("../conexao/conexao.php");

    // Preparar a consulta SQL para excluir o produto
    $stmt = $conexao->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $produto_id);

    // Obter o ID do produto da URL
    $produto_id = $_GET['id'];

    if ($stmt->execute()) {
        // Produto excluído com sucesso,voltar para a página de produtos
        header("Location: produtos.php");
        exit();
    } else {
        // Se a exclusão falhar
        echo "Falha ao excluir o produto.";
    }

    // Fechar a declaração
    $stmt->close();

    // Fechar a conexão com o banco de dados
    $conexao->close();
} else {
    echo "ID de produto inválido.";
}
?>
