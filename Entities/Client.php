<?php

namespace Entities;

use Classes\Database;

require __DIR__.'/../vendor/autoload.php';

class Client {

    public $id;
    public $nome;
    public $email;
    public $cidade;
    public $estado;
    public $telefone;

    public function adicionar() {
        $db = new Database('clientes');

        $this->id = $db->insert([
            'nome' => $this->nome,
            'email' => $this->email,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'telefone' => $this->telefone,
        ]);

        return true;
    }

    public function atualizar($id) {
        $db = new Database('clientes');

        $db->update([
            'nome' => $this->nome,
            'email' => $this->email,
            'cidade' => $this->cidade,
            'estado' => $this->estado,
            'telefone' => $this->telefone,
        ], $id);

        return true;
    }

    public function deletar($id) {
        $db = new Database('clientes');

        $result = $db->select(' id = '.$id);

        if ($result->rowCount() > 0) {
            $db->delete($id);
            return true;
        }

        return false;
    }
    
    public static function getClientes($where = null, $order = null, $limit = null) {
        return (new Database('clientes'))->select($where, $order, $limit)->fetchAll();
    }

    public static function getClient($where = null) {
        return (new Database('clientes'))->select($where)->fetchObject(self::class);
    }
}
