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
use Model\EventosRegistros;

class RegistrosController {

    public static function crear(Router $router) {

        if(!isAuth()) {
            header('Location: /');
            return;
        }

        // Verificar si el usuario ya esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);
        if(isset($registro) && $registro->paquete_id === "3" || $registro->paquete_id === "2") {
            header("Location: /boleto?id=" . urlencode($registro->token));
            return;
        }

        if(isset($registro) && $registro->paquete_id === "1") {
            header("Location: /finalizar-registro/conferencias");
            return;
        }

        //debug($registro);

        $router -> render('registros/crear',  [
            'titulo' => 'Finalizar Registro',
        ]);
    }

    public static function gratis(Router $router) {

        if($_SERVER["REQUEST_METHOD"] === "POST") {

            if(!isAuth()) {
                header("Location: /login");
                return;
            }

            // Verificar si el usuario ya esta registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);
            //debug($registro);
            if(isset($registro) && $registro->paquete_id === "3") {
                header("Location: /boleto?id=" . urlencode($registro->token));
                return;
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
                return;
            }
        }
    }

    public static function boleto(Router $router) {

        // Validar que el usuario este autenticado
        if(!isAuth()) {
            header('Location: /login');
            return;
        }
        
        // Validar la URL
        $id = $_GET['id'];
        if(!$id || !strlen($id) === 8) {
            header('Location: /');
            return;
        }

        // Buscarlo en la BD
        $registro = Registro::where('token', $id);
        if(!$registro) {
            header('Location: /');
            return;
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
                return;
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
        if (!isAuth()) {
            echo json_encode(['resultado' => 'error', 'mensaje' => 'No autenticado']);
            return;
        }
    
        $usuario_id = $_SESSION["id"];
        $registro = Registro::where('usuario_id', $usuario_id);

        if(isset($registro) && $registro->paquete_id === "2") {
            header("Location: /boleto?id=" . urlencode($registro->token));
            return;
        }
    
        if (!isset($registro) || $registro->paquete_id !== "1") {
            echo json_encode(['resultado' => 'error', 'mensaje' => 'Acceso no permitido']);
            return;
        }

        //Regireccionar a Boleto Virtual en caso de haber finalizdo su registro
        if(isset($registro->regalo_id) && $registro->paquete_id === "1") {
            header("Location: /boleto?id=" . urlencode($registro->token));
            return;
        }
    
        // Ordenar eventos por su hora de manera ascendente
        $eventos = Evento::ordenar('hora_id', 'ASC');
    
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
    
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // verificar si el usuario esta autenticado
            if (!isAuth()) {
                echo json_encode(['resultado' => 'error', 'mensaje' => 'No autenticado']);
                return;
            }
    
            // Formatear eventos
            $eventos = explode(',', $_POST['eventos']);
            if (empty($eventos)) {
                echo json_encode(['resultado' => 'error', 'mensaje' => 'No hay eventos seleccionados']);
                return;
            }
    
            // Validar que el usuario tenga el paquete de conferencias
            $registro = Registro::where('usuario_id', $_SESSION["id"]);
            if (!isset($registro) || $registro->paquete_id !== "1") {
                echo json_encode(['resultado' => 'error', 'mensaje' => 'Acceso no permitido']);
                return;
            }
    
            $eventos_array = [];

            // Validar la disponibilidad de los eventos seleccionados
            foreach ($eventos as $evento_id) {
                $evento = Evento::find($evento_id);
                if (!isset($evento) || $evento->disponibles <= 0) {
                    echo json_encode(['resultado' => 'error', 'mensaje' => 'Evento no disponible']);
                    return;
                }
                $eventos_array[] = $evento;
            }
    
            foreach ($eventos_array as $evento) {
                $evento->disponibles -= 1;
                $evento->guardar();

                // Almacenar el registro
                $datos = [
                    'evento_id' => (int) $evento->id,
                    'registro_id' => (int) $registro->id,
                ];
                //debug($datos);

                $registro_usuario = new EventosRegistros($datos);
                $registro_usuario->guardar();

                //debug($registro_usuario);
            }

            // Almacenar el registro
            $registro->sincronizar(['regalo_id' => $_POST['regalo_id']]);
            $resultado = $registro->guardar();
            //debug($registro);

            if($resultado)  {
                echo json_encode(['resultado' => 'éxito',
                    'mensaje' => 'Tus Conferencias se han almacenado y tu registro fue exitoso, te esperamos en DevWebCamp',
                    'token' => $registro->token,
                ]);
            } else {
                echo json_encode(['resultado' => 'error', 'mensaje' => 'No se pudo realizar el registro']);
            }
            
            return;
        }
    
        $router->render('registros/conferencias',  [
            'titulo' => 'Elige Workshops y Conferencias',
            'eventos' => $eventos_formateados,
            'regalos' => $regalos,
        ]);
    }    
}