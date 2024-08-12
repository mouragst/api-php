<?php

namespace Classes;

require __DIR__.'/../vendor/autoload.php';

use Exception;
use Classes\JWT;
use Classes\Database;

class Users {
    private static function getUser($login) {
        $db = new Database('users');

        $getUser = $db->select("login = '{$login}'")->fetchObject();

        if (!empty($getUser)) {
            return $getUser;
        } else {
            return false;
        }
    }

    private static function updateToken($token, $id) {
        $db = new Database('users');
        $updateTokenById = $db->update(['token' => $token], $id);
        return $updateTokenById;
    }

    private static function getUserByToken($token) {
        $db = new Database('users');
        $token = trim($token);
        $token = $db->select("token = '{$token}'")->fetchObject();

        if (!empty($token)) {
            return $token;
        } else{
            return false;
        };
    }

    private static function deleteToken($id) {
        $db = new Database('users');
        $deleteToken = $db->update(['token' => ''], $id);
        return $deleteToken;
    }

    public function login() {
        if ($_POST) {
            if (!$_POST['login'] || !$_POST['password']) {
                echo json_encode(['ERROR' => 'Require login or password!']);
                exit;
            }
            
            $login = addslashes(htmlspecialchars($_POST['login'])) ?? '';
            $senha = addslashes(htmlspecialchars($_POST['password'])) ?? '';

            $secretJWT = $GLOBALS['secretJWT'];
            $user = self::getUser($login);

            if ($user) {
                $validUsername = true;
            }

            $validPassword = password_verify($senha, $user->password) ? true : false;

            if ($validUsername && $validPassword) {
                $expire_in = time() + 60000;
                $token = JWT::encode([
                    'id' => $user->id,
                    'name' => $user->name,
                    'expires_in' => $expire_in,
                ], $GLOBALS['secretJWT']);

                self::updateToken($token, $user->id);
                echo json_encode(['token' => $token, 'data' => JWT::decode($token, $secretJWT)]);
            } else{
                if (!$validUsername) {
                    echo json_encode(['ERROR' => 'Invalid Credentials']);
                }

                if (!$validPassword) {
                    echo json_encode(['ERROR' => 'Invalid Credentials']);
                }
            }
        }
    }

    public static function verifyUser() {
        $header = apache_request_headers();
        if (isset($header['authorization'])) {
            $token = str_replace("Bearer", "", $header['authorization']);
        } else {
            echo json_encode(['ERROR' => 'Not logged, or invalid token']);
            exit;
        }

        $secretJWT = $GLOBALS['secretJWT'];
        $tokenDB = self::getUserByToken($token);

        if (!empty($tokenDB)) {
            try {
                $decodedJWT = JWT::decode($tokenDB->token, $secretJWT, ['HS256']);

                if ($decodedJWT->expires_in > time()) {
                    return true;
                } else {
                    self::deleteToken($tokenDB->id);
                    echo json_encode(['ERROR' => 'Token expired']);
                    return false;
                }
            } catch (Exception $e) {
                echo json_encode(['ERROR' => 'Invalid token: ' . $e->getMessage()]);
                return false;
            }
        } else {
            echo json_encode(['ERROR' => 'Token not found']);
            return false;
        }
    }
}