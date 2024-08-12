<?php

use Classes\Routes;

require 'vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');

date_default_timezone_set("America/Sao_Paulo");

$GLOBALS['secretJWT'] = '123456';

# Routes

$route = new Routes;
$route->add('POST', '/users/login', 'Users::login', false);
$route->add('GET', '/client/list', 'ClientApi::getAllClients', true);
$route->add('GET', '/client/list/[PARAM]', 'ClientApi::getClient', true);
$route->add('POST', '/client/add', 'ClientApi::addClient', true);
$route->add('PUT', '/client/update/[PARAM]', 'ClientApi::updateClient', true);
$route->add('DELETE', '/client/delete/[PARAM]', 'ClientApi::deleteClient', true);
$route->path($_GET['path']);