<?php

namespace controller;

/**
 * Contiene las rutas de la aplicacion y lee la ruta actual para decidir
 * que controlador y metodo se ejecuta.
 */
class RoutingController {

    // Contiene todas las rutas de la aplicacion junto con los controladores
    // y metodos que se ejecutan para dicha ruta
    private $routes = array(
        "/signup/" => array(
            "controller" => "Index",
            "function" => "signup",
            "anonimous" => true
        ),
        "/save/" => array(
            "controller" => "Index",
            "function" => "save",
            "anonimous" => true
        ),
        "/login/" => array(
            "controller" => "Index",
            "function" => "login",
            "anonimous" => true
        ),
        "/verify/" => array(
            "controller" => "Index",
            "function" => "verify",
            "anonimous" => true
        ),
        "/logout/" => array(
            "controller" => "Index",
            "function" => "logout"
        ),
        "/" => array(
            "controller" => "Meeting",
            "function" => "home"
        ),
        "/meeting/save/" => array(
            "controller" => "Meeting",
            "function" => "save"
        ),
        "/meeting/" => array(
            "controller" => "Message",
            "function" => "home"
        ),
        "/meeting/messages/" => array(
            "controller" => "Message",
            "function" => "fetch_messages"
        ),
        "/meeting/send_message/" => array(
            "controller" => "Message",
            "function" => "send_message"
        ),
        "/meeting/users/" => array(
            "controller" => "Message",
            "function" => "fetch_users"
        ),
        "/prueba/" => array(
            "controller" => "Prueba",
            "function" => "home",
            "anonimous" => true
        )
    );

    /**
     * Lee la uri actual y devuelve el controlador y metodo a ejecutar
     * ademas del rol que se tiene sobre esa ruta.
     * @return array|null
     */
    public function get_controller_function() {
        $uri = $this->get_uri();
        $controller_method = null;

        if (isset($this->routes[$uri])) {
            $controller_method = $this->routes[$uri];
        }

        return $controller_method;
    }


    /**
     * Genera una ruta completa con un controlador y metodo.
     * @param string $controlador_metodo Controlador y metodo para generar la ruta
     * @return string Ruta completa
     */
    public function get_full_route($uri) {
        $full_route = URL_ROOT;

        if (isset($this->routes[$uri])) {
            $full_route .= substr($uri, 1);
        }

        return $full_route;
    }

    /**
     * Devuelve la uri actual
     * @return string
     */
    private function get_uri() {
        return URI;
    }
}
