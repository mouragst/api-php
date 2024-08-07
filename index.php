<?php

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

date_default_timezone_set("America/Sao_Paulo");

if (isset($_GET['path'])) { $path = explode("/", $_GET['path']); } else { echo "Caminho não existe"; }

if (isset($path[0])) { $api = $path[0]; } else { echo "Caminho não existe"; }
if (isset($path[1])) { $acao = $path[1]; } else { $acao = ''; }
if (isset($path[2])) { $parametro = $path[2]; } else { $parametro = ''; }

$method = $_SERVER['REQUEST_METHOD'];

include_once "api/clientes/clientes.php";
include_once "classes/Database.php";
include_once "entities/Client.php";