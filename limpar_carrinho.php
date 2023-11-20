<?php
session_start();
include_once("./conexao/conexao.php");

if (isset($_POST['limpar'])) {
    // Esvaziar os produtos do carrinho
    if (isset($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $produto) {
            $produto_id = $produto['id'];
            $quantidade_devolvida = $produto['quantidade'];

            // Atualiza a quantidade disponível na base de dados
            $atualizar_sql = "UPDATE produtos SET quantidade = quantidade + $quantidade_devolvida WHERE id = $produto_id";
            $atualizar_result = mysqli_query($conexao, $atualizar_sql);

            if (!$atualizar_result) {
                echo "Erro ao atualizar a quantidade no banco de dados: " . mysqli_error($conexao);
            }
        }

        // Limpa o carrinho (remove a variável da sessão)
        unset($_SESSION['carrinho']);
    }
}

// Redireciona de volta para a página anterior
header("Location: ".$_SERVER['HTTP_REFERER']);
exit();
?>