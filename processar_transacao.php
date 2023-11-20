<?php
session_start();
include_once("./conexao/conexao.php"); 

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $dataNascimento = $_POST["data_nascimento"];
    $morada = $_POST["morada"];

    // Validar idade igual ou superior a 18 anos
    $dataNascimentoDate = new DateTime($dataNascimento);
    $hoje = new DateTime();
    $diferenca = $dataNascimentoDate->diff($hoje);
    if ($diferenca->y < 18) {
        header("Location: idade.php");
        exit();
    }

    // Validar campos vazios
    if (empty($nome) || empty($dataNascimento) || empty($morada)) {
        echo "Por favor, preencha todos os campos.";
        exit();
    }

  
    $produtos_vendidos = $_SESSION['carrinho'];

    //  Atualizar os produtos vendidos na base de dados
    foreach ($produtos_vendidos as $produto) {
        $produto_id = $produto['id'];
        $sqlUpdate = "UPDATE produtos SET quantidade = 0 WHERE id = ?";
        $stmtUpdate = $conexao->prepare($sqlUpdate);
        $stmtUpdate->bind_param("i", $produto_id);
        $stmtUpdate->execute();
    }

    // 2. Limpar o carrinho/sessão
    $_SESSION['carrinho'] = array();

    // 3. Inserir dados na tabela de encomendas
    $sqlEncomenda = "INSERT INTO encomendas (utilizador_id, nome_cliente, data_nascimento_cliente, morada_cliente) VALUES (?, ?, ?, ?)";
    $stmtEncomenda = $conexao->prepare($sqlEncomenda);
    $stmtEncomenda->bind_param("isss", $utilizador_id, $nome, $dataNascimento, $morada);

    if ($stmtEncomenda->execute()) {
        $encomenda_id = $stmtEncomenda->insert_id;

        // 4. Inserir detalhes da encomenda na tabela detalhes_encomenda
        foreach ($produtos_vendidos as $produto) {
            $produto_id = $produto['id'];
            $quantidade = $produto['quantidade'];
            $preco_total_produto = $produto['preco'] * $quantidade;

            $sqlDetalhes = "INSERT INTO detalhes_encomenda (encomenda_id, produto_id, quantidade, preco_total_produto) VALUES (?, ?, ?, ?)";
            $stmtDetalhes = $conexao->prepare($sqlDetalhes);
            $stmtDetalhes->bind_param("iiid", $encomenda_id, $produto_id, $quantidade, $preco_total_produto);
            $stmtDetalhes->execute();
        }

        // 5. Redirecionar para a página de confirmação
        header("Location: fim_checkout.php");
        exit();
    } else {
        echo "Erro ao processar a encomenda: " . $stmtEncomenda->error;
    }

    $stmtEncomenda->close();
    $conexao->close();
} else {
    echo "Acesso inválido.";
}
?>
