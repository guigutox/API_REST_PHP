<?php

    include('conexao.php');

    if ($_SERVER['REQUEST_METHOD'] !== 'GET' &&
    $_SERVER['REQUEST_METHOD'] !== 'POST' &&
    $_SERVER['REQUEST_METHOD'] !== 'PUT' &&
    $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405); // Método de requisição não permitido
    exit;
}

header('Content-Type: application/json');

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = $data['nome'];
    $idade = $data['idade'];
    $sql = "INSERT INTO pessoas (nome, idade) VALUES ('$nome', $idade)";
    mysqli_query($conn, $sql);
    $id = mysqli_insert_id($conn);
    echo json_encode(array('id' => $id));
}


?>