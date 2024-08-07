<?php

use Entities\Client;

if ($acao == '' && $parametro == '') { echo json_encode(['ERROR' => 'Caminho não encontrado!']); }

if ($acao == 'adicionar' && $parametro == '') {
    $client = new Client;

    $client->nome = $_POST['nome'];
    $client->email = $_POST['email'];
    $client->cidade = $_POST['cidade'];
    $client->estado = $_POST['estado'];
    $client->telefone = $_POST['telefone'];

    $resultado = $client->adicionar();

    if ($resultado == true) {
        echo json_encode(["dados" => "Dados inseridos com sucesso"]);
    } else {
        echo json_encode(["dados" => "Erro ao inserir dados"]);
    }
}