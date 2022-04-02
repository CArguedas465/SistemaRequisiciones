<?php 
    include '../clases/conexion.php';
    class historial{
        var $obj_conexion;

        public function __construct(){
            $conexion = new conexion();

            $this->obj_conexion = $conexion -> establecerConexion();
        }

        public adicionarEntradaHistorial($estado, $idrequisicion, $aprobador){
            $sql = "INSERT INTO historial VALUES (".$idrequisicion.", SYSDATE(), ".$aprobador.", ".$estado.");";
        }
    }
?>