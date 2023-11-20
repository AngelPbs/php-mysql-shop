<?php
include_once("./conexao/conexao.php");

if (isset($_GET['produto_id'])) {
    $produto_id = $_GET['produto_id'];

    // Consultar a quantidade disponível na base de dados
    $sql_quantidade = "SELECT quantidade FROM produtos WHERE id = $produto_id";
    $result_quantidade = $conexao->query($sql_quantidade);

    if ($result_quantidade && $result_quantidade->num_rows > 0) {
        $row_quantidade = $result_quantidade->fetch_assoc();
        $quantidade_disponivel = $row_quantidade['quantidade'];

        echo json_encode(['quantidade_disponivel' => $quantidade_disponivel]);
    } else {
        echo json_encode(['quantidade_disponivel' => 0]);
    }
}
?>
