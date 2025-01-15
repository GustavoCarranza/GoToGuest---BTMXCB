<?php

class RolesModel extends Mysql
{
    //Atributos o propiedades
    public $intIdRol;
    public $strRol;
    public $strDescripcion;
    public $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los registros de la bd
    public function selectRegistros()
    {
        $sql = "SELECT idRol,nombre,descripcion,status,
        CONCAT(DAY(dateCreate), ' de ', 
        CASE MONTH(dateCreate)
            WHEN 1 THEN 'enero'
            WHEN 2 THEN 'febrero'
            WHEN 3 THEN 'marzo'
            WHEN 4 THEN 'abril'
            WHEN 5 THEN 'mayo'
            WHEN 6 THEN 'junio'
            WHEN 7 THEN 'julio'
            WHEN 8 THEN 'agosto'
            WHEN 9 THEN 'septiembre'
            WHEN 10 THEN 'octubre'
            WHEN 11 THEN 'noviembre'
            WHEN 12 THEN 'diciembre'
        END, ' del ', YEAR(dateCreate)) AS fechaCreacion,DATE_FORMAT(dateCreate, '%h:%i:%s %p') AS horaCreacion FROM roles WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para extraer los roles de la bd
    public function selectRoles()
    {
        $whereAdmin = "";
        // Si el usuario actual no es el super administrador, aplicamos la restricción
        if ($_SESSION['idUsuario'] != 1) {
            $whereAdmin = "AND idRol != 1";
        }

        //Consulta a la base de datospara extraer roles
        $sql = "SELECT * FROM roles WHERE status != 0 $whereAdmin";
        //creamos una variables donde accedemos a la invocacion del metodo select_All que se enceuntra en la clase heredad Mysql
        $request = $this->select_All($sql);
        //Retornamos la variable para que sea funcional en el controlador
        return $request;
    }
    

    //Metodo para insertar roles a la bd
    public function insertRol(string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades
        $this->strRol = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;
        $return = 0;
        //Creamos una variable donde le almacenamos el script de la consulta para verificar si el rol ya existe
        $sql = "SELECT * FROM roles WHERE nombre = '{$this->strRol}'";
        //Creamos una variables para acceder a la invocacion del metodo que pertenece a la clase heredada Mysql
        $request = $this->select_All($sql);
        //Validamos si la variable creada esta vacia entonces hacer la insertacion del rol
        if (empty($request)) {
            //creamos la variables con el script de la consulta para insertar el rol
            $query_insert = "INSERT INTO roles(nombre,descripcion,status,dateCreate) VALUES (?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
            //creamos un arreglo para almacenar los valores de las propiedades 
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
            $request_insert = $this->insert($query_insert, $arrData);
            $return =  $request_insert;
        } else {
            return 0;
        }
        return $return;
    }

    //Metodo para extraer la informacion del rol
    public function selectRol(int $idrol)
    {
        //Asignamos el valor del parametro ala propiedad
        $this->intIdRol = $idrol;
        //Cremos la variable de consulta hacia la base 
        $sql = "SELECT idRol, nombre, descripcion, status FROM roles WHERE idRol = $this->intIdRol";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para actualizar roles
    public function updateRol(int $idrol, string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades 
        $this->intIdRol = $idrol;
        $this->strRol = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        //Creamos una variable para almacenar una consulta a la base para comprobar que el rol con el mismo nombre no este almacenado en la base de datos y si el nombre del rol corresponde al id deje actualizar 
        $sql = "SELECT * FROM roles WHERE (nombre = '{$this->strRol}' AND idRol != $this->intIdRol)";
        $request = $this->select_All($sql);
        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE roles SET nombre = ?, descripcion = ?, status = ? WHERE idRol = $this->intIdRol";
            $arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //Metodo para eliminar roles
    public function deleteRoles(int $rol)
    {
        // Asignamos el valor del parámetro a la propiedad
        $this->intIdRol = $rol;
        // Consulta SQL para actualizar el estado del rol
        $sql = "UPDATE roles SET status = ? WHERE idRol = ?";
        // Arreglo de datos para la consulta preparada
        $arrData = array(0, $this->intIdRol);
        // Ejecutar la consulta SQL
        $request = $this->update($sql, $arrData);
        // Verificar si la consulta fue exitosa y devolver el resultado
        if ($request === true) {
            return 'ok';
        } else {
            return 'error';
        }
    }
}
