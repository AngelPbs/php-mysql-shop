<?php
session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}


include_once("../conexao/conexao.php");
if (isset($_GET['id'])) {
    $encomenda_id = $_GET['id'];

    // obter os detalhes da encomenda para saber quais produtos estão associados a ela
    $sqlDetalhes = "SELECT produto_id, quantidade FROM detalhes_encomenda WHERE encomenda_id = $encomenda_id";
    $resultDetalhes = $conexao->query($sqlDetalhes);

    if ($resultDetalhes) {
        // Percorrer os detalhes da encomenda e atualize a quantidade de produtos na tabela de produtos
        while ($rowDetalhes = $resultDetalhes->fetch_assoc()) {
            $produto_id = $rowDetalhes['produto_id'];
            $quantidade_devolvida = $rowDetalhes['quantidade'];

            // Atualizar a quantidade na tabela de produtos
            $sqlUpdateProduto = "UPDATE produtos SET quantidade = quantidade + $quantidade_devolvida WHERE id = $produto_id";
            $conexao->query($sqlUpdateProduto);
        }

        // Exluir os registros de detalhes da encomenda e da encomenda
        $sqlDeleteDetalhes = "DELETE FROM detalhes_encomenda WHERE encomenda_id = $encomenda_id";
        $sqlDeleteEncomenda = "DELETE FROM encomendas WHERE encomenda_id = $encomenda_id";

        if ($conexao->query($sqlDeleteDetalhes) === TRUE && $conexao->query($sqlDeleteEncomenda) === TRUE) {
            header("Location: encomendas.php");
            exit();
        } else {
            echo "Erro ao cancelar encomenda";
        }
    } else {
        echo "Erro ao obter detalhes da encomenda";
    }
}
