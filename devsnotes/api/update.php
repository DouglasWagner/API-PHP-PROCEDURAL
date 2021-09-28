<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put'){

    parse_str(file_get_contents('php://input'), $input);

    $id = filter_var($input['id'] ?? null);
    $title = filter_var($input['title'] ?? null);
    $body = filter_var($input['body'] ?? null);

    if($id && $title && $body){

    $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if($sql->rowcount() > 0) {

        $sql = $pdo->prepare("UPDATE notes SET title = :title, body = :body WHERE id = :id");
        $sql->bindValue('id', $id);
        $sql->bindValue('title', $title);
        $sql->bindValue('body', $body);
        $sql->execute();
      
        $array['result'] = [
            'id' => $id,
            'title' => $title,
            'body' => $body
        ];
        
    } else {
        $array['error'] = "ID Inexistente";
    }
} else {
    $array['error'] = "ID não enviado";
}
} else {
    $array['error'] = "Método nao perimitido (APENAS PUT)";
}

require('../return.php');