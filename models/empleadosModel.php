<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class empleadosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getEmpleados() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT e.*,td.tipo_documento as tdoc
                                                FROM empleados AS e, tipo_documento AS td 
                                                WHERE e.tipo_documento = td.id ;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   

    public function getEmpleado($id) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT e.*,td.tipo_documento as tdoc
                                                FROM empleados AS e, tipo_documento AS td 
                                                WHERE e.tipo_documento = td.id 
                                                AND e.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function gettido() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from tipo_documento");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarnumdoc($tipodoc, $numdoc) {
        //Se crea y ejecuta la consulta
        $tipodoc = (int) $tipodoc; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.id FROM empleados AS c 
                                            WHERE c.tipo_documento = $tipodoc
                                            AND c.documento = '".$numdoc."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarnumdocedita($id,$tipodoc, $numdoc) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.id FROM empleados AS c 
                                            WHERE c.tipo_documento = $tipodoc
                                            AND c.documento = '".$numdoc."'
                                             AND c.id <> $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function crear_empleado($codigo, $tipo_doc, $numdoc, $nombres, $apellidos, $salario_b, $cargo, $despachador) {

        $this->_db->query("INSERT INTO empleados (codigo, tipo_documento, documento, nombres, apellidos, salario_b, cargo, despachador) VALUES
                            ('".$codigo."', ".$tipo_doc.", '".$numdoc."', '".$nombres."', '".$apellidos."','".$salario_b."','".$cargo."','".$despachador."');");
    }

    public function editar_empleado($id, $codigo, $tipo_doc, $numdoc, $nombres, $apellidos, $salario_b, $cargo, $despachador) {

        $this->_db->query("UPDATE empleados SET codigo='".$codigo."', 
                            tipo_documento=".$tipo_doc.",
                            documento='".$numdoc."', 
                            nombres='".$nombres."', 
                            apellidos='".$apellidos."', 
                            salario_b='".$salario_b."',
                            cargo='".$cargo."',
                            despachador='".$despachador."'
                            WHERE id = $id;");
    }

    public function eliminar_empleado($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM empleados Where id = $id;");
    }
}

?>
