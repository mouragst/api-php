<?php

use Entities\Client;

if ($acao == '' && $parametro == '') { echo json_encode(['ERROR' => 'Caminho não encontrado!']); }

if ($acao == 'lista' && $parametro == '') {
    echo json_encode(Client::getClientes());
}

if ($acao == 'lista' && $parametro != '') {
    echo json_encode(Client::getClient(' id ='.$parametro));
    }


if (empty(Client::getClient())) {
    echo json_encode(['ERROR' => 'Não existem dados para retornar!']);
}