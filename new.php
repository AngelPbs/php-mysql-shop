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
                  header("Location: ".$_SERVER['REQUEST_URI']);
                  exit();
              } else {
                  echo "Erro ao atualizar a quantidade no banco de dados: " . mysqli_error($conexao);
              }
          } else {
              echo ' <p style="color: red; text-align: center; font-size:20px"> Desculpe, a quantidade escolhida não está disponível em stock.</p>';
          }
      } else {
          echo "Erro ao consultar o banco de dados: " . mysqli_error($conexao);
      }
  } else {
      echo ' <p style ="text-align:center">O produto já está no carrinho.</p>';
  }
}
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
                    echo "stock esgotado para este produto.";
                }
                break;
            } else {
                echo "Erro ao consultar o banco de dados: " . mysqli_error($conexao);
            }
        }
    }

    // Redirecionar de volta para a página
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit();
}

  

// Processar botão de decremento
if (isset($_POST['decrementar'])) {
  $produto_nome_decrementar = $_POST['produto_nome'];

  // Encontrar o produto no carrinho e remover uma unidade
  foreach ($_SESSION['carrinho'] as $index => &$produto) {
      if ($produto['nome'] === $produto_nome_decrementar && $produto['quantidade'] > 0) {
          // Remover uma unidade do produto no carrinho
          $produto['quantidade']--;

          // Atualizar a quantidade disponível na base de dados
          $produto_id = $produto['id'];
          $quantidade_adicionada_na_base = 1; // Adicionar uma unidade na base de dados
          $atualizar_sql = "UPDATE produtos SET quantidade = quantidade + $quantidade_adicionada_na_base WHERE id = $produto_id";
          $atualizar_result = mysqli_query($conexao, $atualizar_sql);

          if (!$atualizar_result) {
              echo "Erro ao atualizar a quantidade no banco de dados: " . mysqli_error($conexao);
          }
          
          // Redirecionar de volta para a página
          header("Location: ".$_SERVER['REQUEST_URI']);
          exit();
      }
  }
}
// Ir buscar o id nome preço imagem e quantidade da base dados
$sql = "SELECT id, nome, preco, imagem, quantidade FROM produtos";
$result = $conexao->query($sql);
?>



<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shopping</title>
    <link rel="stylesheet" href="./css/newstyle.css">
   
  </head>
  <body>
  <nav class="navbar">
          <a href="./index.html">Home</a>

          <a href="./checkout.php">Checkout</a>
    
    </nav>
  <div class="layout-pag">
        <div class="w80">
        <?php
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="produtos">
                <img src="./imagens/<?php echo $row['imagem']; ?>" alt="" />
                <span>Nome: <?php echo $row['nome']; ?></span>
                <span>Preço: <?php echo $row['preco']; ?></span>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" class="add-to-cart-form">
                    <input type="hidden" name="produto_id" value="<?php echo $row['id']; ?>" />
                    <input type="hidden" name="produto_nome" value="<?php echo $row['nome']; ?>" />
                    <input type="hidden" name="produto_preco" value="<?php echo $row['preco']; ?>" />
                    <input type="hidden" name="quantidade" min="1" max="<?php echo $row['quantidade']; ?>" value="1" />

                    <button type="submit" name="adicionar">Adicionar</button>
                </form>
            </div>
            <?php
        }
        ?>
        </div>
        <div class="w20">
          <a href="./imagens/1.png"></a>
            <h2>Produtos no Carrinho</h2>
            <div id="carrinho-produtos">
            <?php
            $produtosAgrupados = array();

            // Agrupar produtos pelo nome e calcular a quantidade total
            foreach ($_SESSION['carrinho'] as $produto) {
                $produto_nome = $produto['nome'];
                if (!isset($produtosAgrupados[$produto_nome])) {
                    $produtosAgrupados[$produto_nome] = $produto;
                } else {
                    $produtosAgrupados[$produto_nome]['quantidade'] += $produto['quantidade'];
                }
            }

            // Exibir produtos agrupados
            foreach ($produtosAgrupados as $produto) {
                echo '<div class="carrinho-produto">';
                echo '<div class="produto-info">';
                echo '<span>' . $produto['nome'] . '</span>';
                echo '<span>' . ' x' . $produto['quantidade'] . '</span>';
                echo '</div>';
                echo '<div class="produto-buttons">';
                echo '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" class="decrement-form">';
                echo '<input type="hidden" name="produto_nome" value="' . $produto['nome'] . '" />';
                echo '<button type="submit" class="incrementar" name="incrementar">+</button>';
                echo '<button type="submit" class="decrementar" name="decrementar">-</button>';
                echo '</form>';
                echo '</div>';
                echo '</div>';
            }

            // Calcular o valor total dos produtos no carrinho
            $total = 0;
            foreach ($produtosAgrupados as $produto) {
                $total += ($produto['preco'] * $produto['quantidade']);
            }

            // Exibir o valor total dos produtos no carrinho
            echo '<p>Valor Total: ' . number_format($total, 2) . '€' . '</p>';
            ?>
            <form action="limpar_carrinho.php" method="post">
            <button id="btn-clear" type="submit" name="limpar">Limpar Carrinho</button>
        </form>
        </div>
    </div>

    <script>
    
</script>
  </body>
</html>
