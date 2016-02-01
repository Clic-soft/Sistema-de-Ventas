<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
date_default_timezone_set('America/Bogota');
//Clase extendida de la clase model 
class usuariosModel extends Model {

    //Se crea el constructor
    public function __construct() {
        parent::__construct();
    }

    public function getUsuarios() {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_results("SELECT u.* FROM usuarios AS u");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function getUsuario($id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.* FROM usuarios AS u WHERE u.id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarusuario($usuario) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.id FROM usuarios AS u WHERE u.usuario = '".$usuario."';");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function validarusuarioedita($usuario,$id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.id FROM usuarios AS u WHERE u.usuario = '".$usuario."'
                and id != $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    function validarPassword($password1, $password2) {
        //NO coinciden
        if ($password1 != $password2)
            return false;
        else
            return true;
    }

    public function crear_usuario($usuario, $pass) {

        $this->_db->query("INSERT INTO usuarios (usuario, pass) VALUES
                            ('".$usuario."',
                            '". Hash::getHash('md5', $pass, HASH_KEY) ."');");
    }

    public function editar_usuario($id, $usuario, $estado) {

        $this->_db->query("UPDATE usuarios SET usuario='".$usuario."',
                            estado=".$estado."
                            WHERE id = $id;");
    }

    public function validarclave($pass,$id) {
        //Se crea y ejecuta la consulta
            $consulta = $this->_db->get_row("SELECT u.id FROM usuarios AS u WHERE u.pass = '". Hash::getHash('md5', $pass, HASH_KEY) ."'
                and id = $id;");
        //Se retorna la consulta y se recorren los registros
        return $consulta;
    }

    public function editar_clave($id, $pass) {

        $this->_db->query("UPDATE usuarios SET pass='". Hash::getHash('md5', $pass, HASH_KEY) ."'
                            WHERE id = $id;");
    }

    public function eliminar_usuario($id) {
        $id = (int) $id; /* Parse de la variable */
        $this->_db->query("Delete FROM usuarios Where id = $id;");
    }
}

?>
