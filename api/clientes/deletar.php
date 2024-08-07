<?php

use Entities\Client;

if ($acao == '' && $parametro == '') { echo json_encode(['ERROR' => 'Caminho não encontrado!']); }

if ($acao == 'deletar' && $parametro == '') { echo json_encode(['ERROR' => 'É necessário informar um cliente!']); }

if ($acao == 'deletar' && $parametro != '') {
    $resultado = (new Client)->deletar($parametro);

    if ($resultado == true) {
        echo json_encode(["dados" => "Dado deletado com sucesso"]);
    } else {
        echo json_encode(["dados" => "Erro ao deletar dados"]);
    }
}