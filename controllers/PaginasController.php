<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Ponente;
use Model\Categoria;

class PaginasController {
    public static function index(Router $router) {

        $eventos = Evento::ordenar('hora_id', 'ASC');
        //debug($eventos);

        $eventos_formateados = [];

        foreach($eventos as $evento) {

            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            if($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_viernes'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_sabado'][] = $evento;
            }

            if($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_viernes'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_sabado'][] = $evento;
            }
        }

        // Obtener el total de cada blocque
        $ponentes_total = Ponente::total();
        $conferencias_total = Evento::total('categoria_id', 1);
        $workshops_total = Evento::total('categoria_id', 2);

        // Obtener el total de ponentes
        $ponentes = Ponente::all();

        $router->render('paginas/index', [
            'titulo' => 'Inicio',
            'eventos' => $eventos_formateados,
            'ponentes_total' => $ponentes_total,
            'conferencias_total' => $conferencias_total,
            'workshops_total' => $workshops_total,
            'ponentes' => $ponentes,
        ]);
    }

    public static function evento(Router $router) {

        $router->render('paginas/devwebcamp', [
            'titulo' => 'Sobre DevWebCamp',
        ]);
    }
    
    public static function paquetes(Router $router) {

        $router->render('paginas/paquetes', [
            'titulo' => 'Paquetes DevWebCamp',
        ]);
    }

    public static function conferencias(Router $router) {

        $eventos = Evento::ordenar('hora_id', 'ASC');
        //debug($eventos);

        $eventos_formateados = [];

        foreach($eventos as $evento) {

            $evento->categoria = Categoria::find($evento->categoria_id);
            $evento->dia = Dia::find($evento->dia_id);
            $evento->hora = Hora::find($evento->hora_id);
            $evento->ponente = Ponente::find($evento->ponente_id);

            if($evento->dia_id === "1" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_viernes'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "1") {
                $eventos_formateados['conferencias_sabado'][] = $evento;
            }

            if($evento->dia_id === "1" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_viernes'][] = $evento;
            }

            if($evento->dia_id === "2" && $evento->categoria_id === "2") {
                $eventos_formateados['workshops_sabado'][] = $evento;
            }
        }

        //debug($eventos_formateados);

        $router->render('paginas/workshops-conferencias', [
            'titulo' => 'Conferencias & Workshops',
            'eventos' => $eventos_formateados,
        ]);
    }
}