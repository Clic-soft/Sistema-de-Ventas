<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class proveedoresModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getProveedores() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT c.*,te.tipo_cliente as tdoc
                                                FROM proveedores AS c, tipo_clientes as te 
                                                WHERE c.id_tipo_cliente = te.id ;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getProveedor($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT c.*,te.tipo_cliente as tdoc
                                                FROM proveedores AS c, tipo_clientes as te 
                                                WHERE c.id_tipo_cliente = te.id ANd c.id=$id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

   
    public function gettipe() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT * from tipo_clientes");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarnumdoc($numdoc) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT c.id FROM proveedores AS c 
                                            WHERE c.nit = '".$numdoc."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function validarnumdocedita($id, $numdoc) {
        //Se crea y ejecuta la consulta
        $id = (int) $id; /* Parse de la variable */
            $consulta = $this->_db->get_row("SELECT c.id FROM proveedores AS c 
                                            WHERE c.nit = '".$numdoc."'
                                             AND c.id <> $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }
    
    public function crear_proveedores($tipo_pro, $tipo_emp, $autoret, $nit, $repc, $rsocial,
                                     $con, $tel, $dir, $email) {

        $this->_db->query("INSERT INTO proveedores (id_tipo_cliente, nit, razon_social, rep_legal,
                        contacto, numero_contacto, email_contacto, direccion, estado, 
                        tipo_proveedor, autoretenedor)VALUES
                            (".$tipo_emp.", ".$nit.", '".$rsocial."', '".$repc."', '".$con."', '".$tel."',
                            '".$email."', '".$dir."' ,1 , '".$tipo_pro."', '".$autoret."');");

    }

    public function editar_proveedores($id, $tipo_pro, $tipo_emp, $autoret, $nit, $repc, $rsocial,
                                     $con, $tel, $dir, $email, $estado) {

        $this->_db->query("UPDATE proveedores SET id_tipo_cliente='".$tipo_emp."', 
                            tipo_proveedor=".$tipo_pro.",
                            nit='".$nit."', 
                            autoretenedor='".$autoret."', 
                            razon_social='".$rsocial."', 
                            rep_legal='".$repc."', 
                            contacto='".$con."', 
                            numero_contacto='".$tel."', 
                            direccion='".$dir."', 
                            email_contacto='".$email."', 
                            estado=".$estado."
                            WHERE id = $id;");
    }

    public function eliminar_proveedor($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM proveedores Where id = $id;");
    }
}

?>
