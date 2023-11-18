<?php
session_start();
include_once("./conexao/conexao.php");

$produtosNoCarrinho = array();

if (isset($_SESSION['carrinho'])) {
    $produtosNoCarrinho = $_SESSION['carrinho'];
}



if (isset($_POST['adicionar'])) {
  $produto_id = $_POST['produto_id'];
  $produto_nome = $_POST['produto_nome'];
  $produto_preco = $_POST['produto_preco'];

  $quantidade_escolhida = 1; 

  // Verificar se o produto já está no carrinho
  $produto_no_carrinho = false;
  foreach ($produtosNoCarrinho as $produtoCarrinho) {
      if ($produtoCarrinho['id'] == $produto_id) {
          $produto_no_carrinho = true;
          break;
      }
  }

  if (!$produto_no_carrinho) {
      // Consulta para obter a quantidade disponível do produto
      $sql = "SELECT quantidade FROM produtos WHERE id = $produto_id";
      $result = mysqli_query($conexao, $sql);

      if ($result) {
          $row = mysqli_fetch_assoc($result);
          $quantidade_disponivel = $row['quantidade'];

          if ($quantidade_disponivel >= $quantidade_escolhida) {
              // Atualizar a quantidade disponível no banco de dados
              $nova_quantidade_disponivel = $quantidade_disponivel - $quantidade_escolhida;
              $atualizar_sql = "UPDATE produtos SET quantidade = $nova_quantidade_disponivel WHERE id = $produto_id";
              $atualizar_result = mysqli_query($conexao, $atualizar_sql);

              if ($atualizar_result) {
                  // Adicionar o produto ao carrinho na sessão
                  $_SESSION['carrinho'][] = array(
                      'id' => $produto_id,
                      'nome' => $produto_nome,
                      'preco' => $produto_preco,
                      'quantidade' => $quantidade_escolhida
                  );

                  // Redirecionar de volta para a página anterior
                  header("Location: /masted%20d/projectofinal/new.php");
                
              } else {
                  echo "Erro ao atualizar a quantidade no banco de dados: " . mysqli_error($conexao);
              }
          } else {
            header("Location: new.php?resultado=QUANTITY_NOT_AVAILABLE");
          }
      } else {
          echo "Erro ao consultar o banco de dados: " . mysqli_error($conexao);
      }
  } else {
        header("Location: new.php?resultado=PRODUCT_ALREADY_ADDED");
  }
}

