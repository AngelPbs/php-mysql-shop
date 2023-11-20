<?php


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "teste";

$conexao = new mysqli($servername, $username, $password, $dbname);

if ($conexao->connect_error) {
    die("Conexão falhou ");
}


?>