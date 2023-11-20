<?php
session_start();
include_once("./conexao/conexao.php");


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
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="./css/checkoutstyle.css">
    <style>
      
    
    </style>
     <script>
        function validarFormulario() {
            const nome = document.getElementById('nome').value;
            const dataNascimento = document.getElementById('data_nascimento').value;
            const morada = document.getElementById('morada').value;

            // Validar idade igual ou superior a 18 anos
            const dataNascimentoDate = new Date(dataNascimento);
            const hoje = new Date();
            const idade = hoje.getFullYear() - dataNascimentoDate.getFullYear();
            const mesDiferenca = hoje.getMonth() - dataNascimentoDate.getMonth();
            if (mesDiferenca < 0 || (mesDiferenca === 0 && hoje.getDate() < dataNascimentoDate.getDate())) {
                idade--;
            }

            if (idade < 18) {
                alert('É necessário ter pelo menos 18 anos para realizar a encomenda.');
                return false;
            }

            // Validar campos vazios
            if (nome.trim() === '' || dataNascimento.trim() === '' || morada.trim() === '') {
                alert('Por favor, preencha todos os campos.');
                return false;
            }

            return true; // Permite enviar o formulário se todas as validações passarem
        }
    </script>
</head>
<body>
<nav class="navbar">
          <a href="index.html">Home</a>
        
          <a href="./new.php">Carrinho</a>
    
    </nav>
    <div class="layout">
    <h1>Checkout</h1>
    <div class="container">
    <table border="1">
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Preço Unitário</th>
        <th>Total</th>
    </tr>
    <?php
    $totalCheckout = 0;

    foreach ($produtosAgrupados as $produto_nome => $produto) {
        $totalProduto = $produto['preco'] * $produto['quantidade'];
        $totalCheckout += $totalProduto;

        echo '<tr>';
        echo '<td>' . $produto_nome . '</td>';
        echo '<td>' . $produto['quantidade'] . '</td>';
        echo '<td>' . number_format($produto['preco'], 2) . '€</td>';
        echo '<td>' . number_format($totalProduto, 2) . '€</td>';
        echo '</tr>';
    }
    ?>
    <tr>
        <td colspan="3" id="total"><strong>Total:</strong></td>
        <td><?php echo number_format($totalCheckout, 2) . '€'; ?></td>
    </tr>
</table>

<form action="processar_transacao.php" method="post">
    <h2>Os seus dados para envio</h2>
    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" required>
    <br>
    <label for="data_nascimento">Data de Nascimento:</label> <br>
    <input type="date" id="data_nascimento" name="data_nascimento" required>
    <br>
    <label for="morada">Morada:</label> <br>
    <input type="text" id="morada" name="morada" required>
    <br>
    <button type="submit" id="encomenda">Concluir Encomenda</button>
</form>
</div>

</div>

</body>
</html>