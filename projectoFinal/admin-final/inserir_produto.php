<?php
session_start();
if (!isset($_SESSION['nome']) || $_SESSION['role'] !== 'admin') {
  header("Location: admin-login.php");
  exit();
}


include_once("../conexao/conexao.php"); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $preco = $_POST["preco"];
    $imagem = $_FILES["imagem"];
    $imagem_nome = $imagem["name"];
    $imagem_tmp = $imagem["tmp_name"];
    $imagem_tipo = $imagem["type"];
    $imagem_tamanho = $imagem["size"];

    // Pasta para  onde as imagens serão salvas
    $diretorio_destino = "../imagens/";

    // Verificar se a imagem é válida nos formatos jgep ou png 
    if (in_array($imagem_tipo, ["image/jpeg", "image/png"]) && $imagem_tamanho <= 5 * 1024 * 1024) {
        $caminho_destino = $diretorio_destino . $imagem_nome;
        move_uploaded_file($imagem_tmp, $caminho_destino);

        $sql = "INSERT INTO produtos (nome, quantidade, preco, imagem) VALUES ('$nome', '$quantidade', '$preco', '$caminho_destino')";

        if ($conexao->query($sql) === TRUE) {
            header("location: ./prod.inserido.php");
        } else {
            echo "Erro ao inserir produto " ;
        }
    } else {
        echo "Formato ou tamanho de imagem inválido.";
    }
}

$conexao->close();
?>
