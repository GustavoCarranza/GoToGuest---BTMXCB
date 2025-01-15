<?php

class QuejasModel extends Mysql
{
    //Propiedades
    private $intIdQueja;
    private $strNombre;
    private $strDescripcion;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los registros de la tabla
    public function selectRegistros()
    {
        $sql = "SELECT idQueja,nombre,descripcion,status, CONCAT(DAY(dateCreate), ' de ', 
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
            END, ' del ', YEAR(dateCreate)) AS fechaCreacion,DATE_FORMAT(dateCreate, '%h:%i:%s %p') AS horaCreacion FROM quejas WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para insertar quejas a la bd
    public function insertQueja(string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;
        $return = 0;
        //Creamos una variable donde le almacenamos el script de la consulta para verificar si el rol ya existe
        $sql = "SELECT * FROM quejas WHERE nombre = '{$this->strNombre}'";
        //Creamos una variables para acceder a la invocacion del metodo que pertenece a la clase heredada Mysql
        $request = $this->select_All($sql);
        //Validamos si la variable creada esta vacia entonces hacer la insertacion del rol
        if (empty($request)) {
            //creamos la variables con el script de la consulta para insertar el rol
            $query_insert = "INSERT INTO quejas(nombre,descripcion,status,dateCreate) VALUES (?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
            //creamos un arreglo para almacenar los valores de las propiedades 
            $arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
            //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
            $request_insert = $this->insert($query_insert, $arrData);
            $return =  $request_insert;
        } else {
            return 0;
        }
        return $return;
    }

    //Metodo para extraer la informacion de la queja 
    public function selectQueja(int $idqueja)
    {
        //Asignamos el valor del parametro ala propiedad
        $this->intIdQueja = $idqueja;
        //Cremos la variable de consulta hacia la base 
        $sql = "SELECT idQueja, nombre, descripcion, status FROM quejas WHERE idQueja = $this->intIdQueja";
        $request = $this->select($sql);
        return $request;
    }

    //metodo para actualizar las quejas 
    public function updateQueja(int $idqueja, string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades 
        $this->intIdQueja = $idqueja;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        //Creamos una variable para almacenar una consulta a la base para comprobar que el rol con el mismo nombre no este almacenado en la base de datos y si el nombre del rol corresponde al id deje actualizar 
        $sql = "SELECT * FROM quejas WHERE (nombre = '{$this->strNombre}' AND idQueja != $this->intIdQueja)";
        $request = $this->select_All($sql);
        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE quejas SET nombre = ?, descripcion = ?, status = ? WHERE idQueja = $this->intIdQueja";
            $arrData = array($this->strNombre, $this->strDescripcion, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //metodo para eliminar quejas
    public function deleteQuejas(int $idqueja)
    {
        // Asignamos el valor del parámetro a la propiedad
        $this->intIdQueja = $idqueja;
        // Consulta SQL para actualizar el estado del rol
        $sql = "UPDATE quejas SET status = ? WHERE idQueja = ?";
        // Arreglo de datos para la consulta preparada
        $arrData = array(0, $this->intIdQueja);
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
