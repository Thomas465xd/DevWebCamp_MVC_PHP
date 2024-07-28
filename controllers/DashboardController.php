<?php

namespace Controllers;

use MVC\Router;
use Model\Evento;
use Model\Usuario;
use Model\Registro;

class DashboardController {

    public static function index(Router $router) {

        if(!isAdmin()) {
            header("Location: /login");
        }

        // Obtener ultimos registros
        $registros = Registro::get(5);
        foreach($registros as $registro) {
            $registro->usuario = Usuario::find($registro->usuario_id);
        }

        // Calcular los Ingresos
        $virtuales = Registro::total("paquete_id", 2);
        $presenciales = Registro::total("paquete_id", 1);

        $ingresos = ($virtuales * 46.41) + ($presenciales * 189.54);

        // Obtener eventos con más y menos lugares disponibles
        $menos_disponibles = Evento::ordenarLimite("disponibles", "ASC", 5);
        $mas_disponibles = Evento::ordenarLimite("disponibles", "DESC", 5);

        //debug($mas_disponibles);
        //debug($menos_disponibles);

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración',
            'registros' => $registros,
            'ingresos' => $ingresos, 
            'menos_disponibles' => $menos_disponibles,
            'mas_disponibles' => $mas_disponibles
        ]);
    }
}