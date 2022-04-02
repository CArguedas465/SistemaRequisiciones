<?php 
    include_once '../clases/conexion.php';
    
    class historial{
        var $obj_conexion;

        public function __construct(){
            $conexion = new conexion();

            $this->obj_conexion = $conexion -> establecerConexion();
        }

        public function adicionarEntradaHistorial($estado, $idrequisicion, $asignacion){
            
            $sql = "INSERT INTO historial VALUES (".$idrequisicion.", SYSDATE(), ".$asignacion.", '".$estado."');";

            echo $sql;
            $resultadoEntradaHistorial = $this->obj_conexion -> query($sql);

            return $resultadoEntradaHistorial;
        }
    }
?>