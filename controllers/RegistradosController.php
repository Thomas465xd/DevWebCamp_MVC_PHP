<?php

namespace Controllers;

use MVC\Router;

class RegistradosController {

    public static function index(Router $router) {

        if(!isAdmin()) {
            header("Location: /login");
        }

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
        ]);
    }
}