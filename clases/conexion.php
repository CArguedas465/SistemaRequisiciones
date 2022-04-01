<?php
    class conexion {

        var $cons_usuario = 'root';
        var $cons_contra = '';
        var $cons_baseDatos = 'sistema_requisiciones';
        var $cons_equipo = 'localhost';

        public function establecerConexion(){
            return mysqli_connect($this->cons_equipo, $this->cons_usuario, $this->cons_contra, $this->cons_baseDatos);
        }
    }
?>