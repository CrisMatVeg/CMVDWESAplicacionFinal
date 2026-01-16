<?php
    require_once './core/231018libreriaValidacion.php';
    require_once './model/Usuario.php';
    require_once './model/UsuarioPDO.php';
    require_once './model/AppError.php';
    $controller=[
        "inicioPublico" => "controller/cInicioPublico.php",
        "Login" => "controller/cLogin.php",
        "inicioPrivado" => "controller/cInicioPrivado.php",
        "Detalle" => "controller/cDetalle.php",
        "MiCuenta" => "controller/cMiCuenta.php",
        "BorrarUsuario" => "controller/cBorrarUsuario.php",
        "CambiarPassword" => "controller/cCambiarPassword.php",
        "Registro" => "controller/cRegistro.php",
        "WIP" => "controller/cWIP.php",
        "error" => "controller/cError.php"
    ];
    $view=[
        "inicioPublico" => "view/vInicioPublico.php",
        "inicioPrivado" => "view/vInicioPrivado.php",
        "layout" => "view/layout.php",
        "Login" => "view/vLogin.php",
        "Detalle" => "view/vDetalle.php",
        "MiCuenta" => "view/vMiCuenta.php",
        "BorrarUsuario" => "view/vBorrarUsuario.php",
        "CambiarPassword" => "view/vCambiarPassword.php",
        "Registro" => "view/vRegistro.php",
        "WIP" => "view/vWIP.php",
        "error" => "view/vError.php"
    ];
?>