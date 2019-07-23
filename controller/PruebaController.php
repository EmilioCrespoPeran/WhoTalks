<?php
namespace controller;

class PruebaController extends ApplicationController {


    public function home() {
        parent::response('prueba.html.twig');
    }

}