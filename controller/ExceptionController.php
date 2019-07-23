<?php
namespace controller;

/**
 * Description of ExceptionController
 */
class ExceptionController {

    private $template;

    public function __construct($template_engine) {
        $this->template = $template_engine;
    }

    public function display_error($description = 'No se ha encontrado la pagina', $url = '', $section = '') {
        header("HTTP/1.0 404 Not Found");
        $this->template->display(
            'errors/error.html.twig',
            array(
                'error_descripcion' => $description,
                'error_url' => $url
            )
        );
    }
}