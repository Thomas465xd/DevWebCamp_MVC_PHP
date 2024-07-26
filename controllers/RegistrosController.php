<?php

namespace Controllers;

use Model\Dia;
use Model\Hora;
use MVC\Router;
use Model\Evento;
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
}