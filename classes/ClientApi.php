<?php

namespace Classes;

use Entities\Client;

class ClientApi {
    public function getAllClients() {
        $clients = Client::getClientes();

        if ($clients) {
            echo json_encode(["data" => $clients]); 
        } else {
            echo json_encode(["data" => "Client doesn't exist"]);
        }
    }

    public function getClient($id) {
        $client = Client::getClient('id = '.$id);

        if ($client) {
            echo json_encode(["data" => $client]);
        } else {
            echo json_encode(["data" => "Client doesn't exist"]);
        }
    }

    public function addClient() {
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

    public function updateClient($param) {
        $client = (new Client)->getClient(" id = ".$param);

        isset($_POST['nome']) ? $client->nome = $_POST['nome'] :  $client->nome;
        isset($_POST['email']) ? $client->email = $_POST['email'] : $client->email;
        isset($_POST['cidade']) ? $client->cidade = $_POST['cidade'] : $client->cidade;
        isset($_POST['estado']) ? $client->estado = $_POST['estado'] : $client->estado;
        isset($_POST['telefone']) ? $client->telefone = $_POST['telefone'] : $client->telefone;
    
        $resultado = $client->atualizar($param);
    
        if ($resultado == true) {
            echo json_encode(["dados" => "Dados atualizados com sucesso"]);
        } else {
            echo json_encode(["dados" => "Erro ao atualizar dados"]);
        }
    }

    public function deleteClient($param) {
        $resultado = (new Client)->deletar($param);

        if ($resultado == true) {
            echo json_encode(["dados" => "Dado deletado com sucesso"]);
        } else {
            echo json_encode(["dados" => "Erro ao deletar dados"]);
        }
    }
}