<?php
if (isset($_REQUEST['atras'])) {
    $_SESSION['paginaEnCurso'] = $_SESSION['paginaAnterior'];
    header('Location: index.php');
    exit;
}
require_once $view["layout"];