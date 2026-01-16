<?php
    $avError = [
        'codError' => '',
        'descError' => '',
        'archivoError' => '',
        'lineaError' => '',
        'paginaSiguiente' => ''
    ];

    if(isset($_SESSION['error'])){
        $oError=$_SESSION['error'];
        $avError=[
            'codError'=>$oError->getCodError(),
            'descError'=>$oError->getDescError(),
            'archivoError'=>$oError->getArchivoError(),
            'lineaError'=>$oError->getLineaError(),
            'paginaSiguiente'=>$oError->getPaginaSiguiente()
        ];
        unset($_SESSION['error']);
    }

    if(isset($_REQUEST['atras'])){
        $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
        header('Location: indexLoginLogoff.php');
        exit;
    }
    require_once $view['layout'];
