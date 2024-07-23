<?php

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) : bool {
    return str_contains( $_SERVER["PATH_INFO"], $path ) ? true : false;
}

function isAuth() : bool {
    if( !isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION["nombre"]) && !empty($_SESSION);
}

function isAdmin() : bool {
    if( !isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION["admin"]) && !empty($_SESSION["admin"]);
}
