<?php

namespace Controllers;

use MVC\Router;

class EventosController {

    public static function index(Router $router) {

        if(!isAdmin()) {
            header("Location: /login");
        }

        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops',
        ]);
    }
}