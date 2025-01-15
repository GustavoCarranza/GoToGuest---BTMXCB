<?php

class DepartamentosModel extends Mysql
{
    //Atributos o propiedades
    public $intIdDepartamento;
    public $strDepartamento;
    public $strDescripcion;
    public $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los departamentos dels bd 
    public function selectDepartamentos()
    {
        $sql = "SELECT * FROM departamento WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para extraer los registros de la bd 
    public function selectRegistros()
    {
        $sql = "SELECT idDepartamento,nombre,descripcion,status, CONCAT(DAY(dateCreate), ' de ', 
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
        END, ' del ', YEAR(dateCreate)) AS fechaCreacion,DATE_FORMAT(dateCreate, '%h:%i:%s %p') AS horaCreacion FROM departamento WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para insertar departamentos a la bd 
    public function insertDepartamentos(string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades
        $this->strDepartamento = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;
        $return = 0;
        //Creamos una variable donde le almacenamos el script de la consulta para verificar si el rol ya existe
        $sql = "SELECT * FROM departamento WHERE nombre = '{$this->strDepartamento}'";
        //Creamos una variables para acceder a la invocacion del metodo que pertenece a la clase heredada Mysql
        $request = $this->select_All($sql);
        //Validamos si la variable creada esta vacia entonces hacer la insertacion del rol
        if (empty($request)) {
            //creamos la variables con el script de la consulta para insertar el rol
            $query_insert = "INSERT INTO departamento(nombre,descripcion,status,dateCreate) VALUES (?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
            //creamos un arreglo para almacenar los valores de las propiedades 
            $arrData = array($this->strDepartamento, $this->strDescripcion, $this->intStatus);
            //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
            $request_insert = $this->insert($query_insert, $arrData);
            $return =  $request_insert;
        } else {
            return 0;
        }
        return $return;
    }

    //Metodo para extraer la informacion de los departamentos
    public function selectDepartamento(int $idDepartamento)
    {
        //Asignamos el valor del parametro ala propiedad
        $this->intIdDepartamento = $idDepartamento;
        //Cremos la variable de consulta hacia la base 
        $sql = "SELECT idDepartamento, nombre, descripcion, status FROM departamento WHERE idDepartamento = $this->intIdDepartamento";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para editar la informacion del departamento
    public function updateDepartamento(int $idDepartamento, string $nombre, string $descripcion, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades 
        $this->intIdDepartamento = $idDepartamento;
        $this->strDepartamento = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;

        //Creamos una variable para almacenar una consulta a la base para comprobar que el rol con el mismo nombre no este almacenado en la base de datos y si el nombre del rol corresponde al id deje actualizar 
        $sql = "SELECT * FROM departamento WHERE (nombre = '{$this->strDepartamento}' AND idDepartamento != $this->intIdDepartamento)";
        $request = $this->select_All($sql);
        if (empty($request)) {
            //creamos la consulta ya para actualizar el registro en la base
            $sql = "UPDATE departamento SET nombre = ?, descripcion = ?, status = ? WHERE idDepartamento = $this->intIdDepartamento";
            $arrData = array($this->strDepartamento, $this->strDescripcion, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //Metodo para eliminar departamentos
    public function deleteDepartamento(int $idDepartamento)
    {
         // Asignamos el valor del parámetro a la propiedad
         $this->intIdDepartamento = $idDepartamento;
         // Consulta SQL para actualizar el estado del rol
         $sql = "UPDATE departamento SET status = ? WHERE idDepartamento = ?";
         // Arreglo de datos para la consulta preparada
         $arrData = array(0, $this->intIdDepartamento);
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


