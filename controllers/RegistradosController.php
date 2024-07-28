<?php

namespace Controllers;

use MVC\Router;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Classes\Paginacion;

class RegistradosController {

    public static function index(Router $router) {

        if(!isAdmin()) {
            header("Location: /login");
            return;
        }

        // Obtener Pagina Actual
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if($pagina_actual === false || $pagina_actual < 1) {
            header("Location: /admin/registrados?page=1");
        }

        $registros_por_pagina = 6;
        $total = Registro::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->totalPaginas() < $pagina_actual) {
            header("Location: /admin/registrados?page=" . $paginacion->totalPaginas());
        }

        $registros = Registro::paginar($registros_por_pagina, $paginacion->offset());
        //debug($registros);

        foreach($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
            $registro->paquete = Paquete::find($registro->paquete_id);
        }
        //debug($registros);

        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Registrados',
            'registros' => $registros,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}