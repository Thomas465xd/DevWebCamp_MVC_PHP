<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
use Model\Regalo;
use Model\Paquete;
use Model\Ponente;
use Model\Usuario;
use Model\Registro;
use Model\Categoria;

class RegistrosController {

    public static function crear(Router $router) {

        if(!isAuth()) {
            header('Location: /');
        }

        // Verificar si el usuario ya esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if(isset($registro) && $registro->paquete_id === "3") {
            header("Location: /boleto?id=" . urlencode($registro->token));
        }

        //debug($registro);

        $router -> render('registros/crear',  [
            'titulo' => 'Crea una Cuenta',
        ]);
    }

    public static function gratis(Router $router) {

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            if(!isAuth()) {
                header("Location: /login");
            }

            // Verificar si el usuario ya esta registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            //debug($registro);
            if(isset($registro) && $registro->paquete_id === "3") {
                header("Location: /boleto?id=" . urlencode($registro->token));
            }

            $token = substr( md5(uniqid(rand(), true)), 0, 8);
            //debug($token);

            // Crear Registro
            $datos = array(
                "paquete_id" => 3,
                "pago_id" => '',
                "token" => $token,
                "usuario_id" => $_SESSION['id']
            );

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado) {
                header("Location: /boleto?id=" . urlencode($registro->token));
            }
        }
    }

    public static function boleto(Router $router) {

        // Validar que el usuario este autenticado
        if(!isAuth()) {
            header('Location: /login');
        }
        
        // Validar la URL
        $id = $_GET['id'];
        if(!$id || !strlen($id) === 8) {
            header('Location: /');
        }

        // Buscarlo en la BD
        $registro = Registro::where('token', $id);
        if(!$registro) {
            header('Location: /');
        }

        // Llenar las tablas de referencias
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        //debug($registro);

        $router -> render('registros/boleto',  [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro,
        ]);
    }

    public static function pagar(Router $router) {

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            if(!isAuth()) {
                header("Location: /login");
            }

            // Validar que POST no venga vacío
            if(empty($_POST)) {
                echo json_encode([]);
                return;
            }

            // Crear el registro
            $datos = $_POST;
            $datos['token'] = substr( md5(uniqid(rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];

            //debug($datos);


            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode(['resultado' => $resultado,]);
                
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error',
                ]);
                return;
            }
        }
    }

    public static function conferencias(Router $router) {

        
        // Validar que el usuario este autenticado
        if(!isAuth()) {
            header('Location: /login');
        }

        // Validar que el usuario tenga el plan presencial
        $usuario_id = $_SESSION["id"];
        $registro = Registro::where('usuario_id', $usuario_id);
        
        if(!isset($registro) || $registro->paquete_id !== "1") {
            header('Location: /');
        }

        $eventos = Evento::ordenar('hora_id', 'ASC');
        //debug($eventos);

        // Conseguir Eventos Formateados
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

        $regalos = Regalo::all('ASC');
        
        $router -> render('registros/conferencias',  [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos,
        ]);
    }
}