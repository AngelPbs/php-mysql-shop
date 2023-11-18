<?php
session_start();
include_once("./conexao/conexao.php");

// Processar botão de incremento
if (isset($_POST['incrementar'])) {
    $produto_nome_incrementar = $_POST['produto_nome'];

    // Encontrar o produto no carrinho e incrementar a quantidade
    foreach ($_SESSION['carrinho'] as &$produto) {
        if ($produto['nome'] === $produto_nome_incrementar) {
            // Consultar o stock disponível para o produto
            $produto_id = $produto['id'];
            $sql = "SELECT quantidade FROM produtos WHERE id = $produto_id";
            $result = mysqli_query($conexao, $sql);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $quantidade_disponivel = $row['quantidade'];

                // Verificar se ainda há stock disponível
                if ($quantidade_disponivel > 0) {
                    // Incrementar a quantidade no carrinho até o limite disponível
                    $quantidade_para_adicionar = min(1, $quantidade_disponivel);
                    $produto['quantidade'] += $quantidade_para_adicionar;

                    // Atualizar o stock no banco de dados
                    $nova_quantidade_disponivel = $quantidade_disponivel - $quantidade_para_adicionar;
                    $atualizar_sql = "UPDATE produtos SET quantidade = $nova_quantidade_disponivel WHERE id = $produto_id";
                    $atualizar_result = mysqli_query($conexao, $atualizar_sql);

                    if (!$atualizar_result) {
                        echo "Erro ao atualizar a quantidade no banco de dados: " . mysqli_error($conexao);
                    }
                } else {
                    echo "Stock esgotado para este produto.";
                }

                // Redirecionar de volta para a página
                header("Location: /masted%20d/projectofinal/new.php");
                exit();
            } else {
                echo "Erro ao consultar o banco de dados: " . mysqli_error($conexao);
            }
        }
    }
}



// Processar botão de decremento
if (isset($_POST['decrementar'])) {
    $produto_nome_decrementar = $_POST['produto_nome'];

    // Encontrar o produto no carrinho e remover uma unidade
    foreach ($_SESSION['carrinho'] as $index => &$produto) {
        if ($produto['nome'] === $produto_nome_decrementar && $produto['quantidade'] > 0) {
            // Remover uma unidade do produto no carrinho
            $produto['quantidade']--;

            // Se a quantidade atingir 0, remover o produto do carrinho
            if ($produto['quantidade'] == 0) {
                unset($_SESSION['carrinho'][$index]);
            }

            // Atualizar a quantidade disponível na base de dados
            $produto_id = $produto['id'];
            $quantidade_adicionada_na_base = 1; // Adicionar uma unidade na base de dados
            $atualizar_sql = "UPDATE produtos SET quantidade = quantidade + $quantidade_adicionada_na_base WHERE id = $produto_id";
            $atualizar_result = mysqli_query($conexao, $atualizar_sql);

            if (!$atualizar_result) {
                echo "Erro ao atualizar a quantidade no banco de dados: " . mysqli_error($conexao);
            }

            header("Location: /masted%20d/projectofinal/new.php");
        }
    }

}
?>
