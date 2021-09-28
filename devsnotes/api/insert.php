<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'post'){

   $title = filter_input(INPUT_POST, 'title');
   $body = filter_input(INPUT_POST, 'body');


    if($title && $body){

    $sql = $pdo->prepare("INSERT INTO notes (title, body) VALUE (:title, :body)");
    $sql->bindValue(':title', $title);
    $sql->bindValue(':body', $title);
    $sql->execute();

    $id = $pdo->lastInsertId();

    $array['result'] = [
        'id' => $id,
        'title' => $title,
        'body' => $body
    ];
    } else {
        $array['error'] = "Campos Invalidos";
    }
} else {
    $array['error'] = "Método nao perimitido (APENAS POST)";
}

require('../return.php');