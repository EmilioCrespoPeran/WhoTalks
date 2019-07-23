<?php
namespace controller;

/**
 * Controlador de las vistas de la aplicacion.
 */
class ViewController {

    private $twig;
    private $url_root;

    public function __construct($template_engine) {
        $this->twig = $template_engine;
        $this->url_root = URL_ROOT;
    }

    public function display($view, $data) {
        echo $this->twig->render($view, array_merge($data, array('url_root' => $this->url_root)));
    }

}
