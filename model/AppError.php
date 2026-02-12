<?php
    Class AppError{
        private $codError;
        private $descError;
        private $archivoError;   
        private $lineaError;
        private $paginaSiguente;

        public function __construct($codError, $descError, $archivoError, $lineaError, $paginaSiguiente) {
            $this->codError = $codError;
            $this->descError = $descError;
            $this->archivoError = $archivoError;
            $this->lineaError = $lineaError;
            $this->paginaSiguente=$paginaSiguiente;
        }

        //getters y setters
        public function getCodError(){
            return $this->codError;
        }
        public function getDescError(){
            return $this->descError;
        }
        public function getArchivoError(){
            return $this->archivoError;
        }
        public function getLineaError(){
            return $this->lineaError;
        }
        public function getPaginaSiguiente(){
            return $this->paginaSiguente;
        }

        public function setCodError($codError){
            $this->codError=$codError;
        }
        public function setDescError($descError){
            $this->descError=$descError;
        }
        public function setArchivoError($archivoError){
            $this->archivoError=$archivoError;
        }
        public function setLineaError($lineaError){
            $this->lineaError=$lineaError;
        }
        public function setPaginaSiguiente($paginaSiguente){
            $this->paginaSiguente=$paginaSiguente;
        }
    }
?>