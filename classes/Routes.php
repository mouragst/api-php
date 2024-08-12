<?php

namespace Classes;

class Routes {

    private $listRoutes = [''];
    private $listCallback = [''];
    private $listProtection = [''];


    public function add($method, $route, $callback, $protection) {
        $this->listRoutes[] = strtoupper($method).':'.$route;
        $this->listCallback[] = $callback;
        $this->listProtection[] = $protection;

        return $this;
    }

    public function path($route) {
        $callback = '';
        $protection = '';
        $param = '';
        $methodServer = isset($_POST['_method']) ? $_POST['_method'] : $_SERVER['REQUEST_METHOD'];
        $route = $methodServer.":/".$route;

        if (substr_count($route, "/") >= 3) {
            $param = substr($route, strrpos($route, "/") + 1);
            $route = substr($route, 0, strrpos($route, "/"))."/[PARAM]";
        }

        $index = array_search($route, $this->listRoutes);
        if ($index > 0) {
            $callback = explode("::", $this->listCallback[$index]);
            $protection = $this->listProtection[$index];
        }

        $class = isset($callback[0]) ? "Classes\\".$callback[0] : '';
        $method = isset($callback[1]) ? $callback[1] : '';

        if (class_exists($class)) {
            if (method_exists($class, $method)) {
                $instanceClass = new $class();
                if ($protection) {
                    if ((new Users())->verifyUser()) {
                        return call_user_func_array(
                            array($instanceClass, $method),
                            array($param)
                        );
                    } else {
                    }
                } else {
                    return call_user_func_array(
                        array($instanceClass, $method),
                        array($param)
                    );
                }
            } else {
                $this->routeDoesntExist();
            }
        } else {
            $this->routeDoesntExist();
        }
    }

    public function routeDoesntExist() {
        http_response_code(404);
    }
}