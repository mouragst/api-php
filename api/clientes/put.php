<?php

use Entities\Client;

if ($acao == '' && $parametro == '') { echo json_encode(['ERROR' => 'Caminho não encontrado!']); }

if ($acao == 'update' && $parametro == '') { echo json_encode(['ERROR' => 'É necessário informar um cliente!']); }

if ($acao == 'update' && $parametro != '') {
    $client = (new Client)->getClient(" id = ".$parametro);

    isset($_POST['nome']) ? $client->nome = $_POST['nome'] :  $client->nome;
    isset($_POST['email']) ? $client->email = $_POST['email'] : $client->email;
    isset($_POST['cidade']) ? $client->cidade = $_POST['cidade'] : $client->cidade;
    isset($_POST['estado']) ? $client->estado = $_POST['estado'] : $client->estado;
    isset($_POST['telefone']) ? $client->telefone = $_POST['telefone'] : $client->telefone;

    $resultado = $client->atualizar($parametro);

    if ($resultado == true) {
        echo json_encode(["dados" => "Dados atualizados com sucesso"]);
    } else {
        echo json_encode(["dados" => "Erro ao atualizar dados"]);
    }
}