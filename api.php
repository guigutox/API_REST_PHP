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
    echo json_encode(array('id' => $id, 'nome' => $nome, 'idade' => $idade));
}

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    $varID = $_GET['id'];
    $varNome = $_GET['nome'];

    $sql = "SELECT * FROM pessoas";
    if($varID){
        $sql .= " WHERE id = $varID";
    }else if($varNome){
        $sql .= " Where nome = $varNome";
    }

    
    $result = mysqli_query($conn, $sql);
    $pessoas = array();
    while ($row = mysqli_fetch_assoc($result)){
        $pessoas[] = $row;
    }
    echo json_encode($pessoas);
}



?>