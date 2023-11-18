<?php
session_start();
include_once("./conexao/conexao.php");

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
    <?php /*if ($_GET['resultado']=='PRODUCT_ALREADY_ADDED'){
              echo ' <p style ="text-align:center">O produto já está no carrinho.</p>';}
        if ($_GET['resultado']=='QUANTITY_NOT_AVAILABLE'){
            echo '<p style="text-align:center; color: red; font-size: 20px;">Desculpe, a quantidade escolhida não está disponível em stock.</p>';
        }*/
        if (isset($_GET['resultado'])) {
            $resultado = $_GET['resultado'];
        
            if ($resultado === 'PRODUCT_ALREADY_ADDED') {
                echo '<p style="text-align:center; color: red; font-size: 20px;">O produto já está no carrinho.</p>';
            } elseif ($resultado === 'QUANTITY_NOT_AVAILABLE') {
                echo '<p style="text-align:center; color: red; font-size: 20px;">Desculpe, a quantidade escolhida não está disponível em stock.</p>';
            }
        }
        
        
        
        ?>
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
                
                <form action="api_adicionar.php" method="post" class="add-to-cart-form">
                    <input type="hidden" name="produto_id" value="<?php echo $row['id']; ?>" />
                    <input type="hidden" name="produto_nome" value="<?php echo $row['nome']; ?>" />
                    <input type="hidden" name="produto_preco" value="<?php echo $row['preco']; ?>" />
                    <input type="hidden" name="quantidade" min="1" max="<?php echo $row['quantidade']; ?>" value="1" />

                    <button type="submit" name="adicionar">add</button>
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

                echo '<form action="api_incre_decre.php" method="post" class="decrement-form">';
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
