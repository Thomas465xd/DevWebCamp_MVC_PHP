<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }


        //if ( $fn ) {
        //    // Call user fn va a llamar una función cuando no sabemos cual sera
        //    call_user_func($fn, $this); // This es para pasar argumentos
        //} else {
        //    echo "Página No Encontrada o Ruta no válida";
        //}

        if (!$fn) {
            http_response_code(404);
            include_once __DIR__ . '/views/404.php';
            return;
        }

        // If route is found, call the associated function
        call_user_func($fn, $this);
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer

        // Utilizar el layout de acuerdo a la URL
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';

        if(str_contains($currentUrl, 'admin')) {
            include_once __DIR__ . '/views/admin-layout.php';
        } else {
            include_once __DIR__ . '/views/layout.php';
        }
    }
}
