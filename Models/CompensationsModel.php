<?php

class CompensationsModel extends Mysql
{
    //Atributos o propiedades
    public $intIdCompensation;
    public $strCompensation;
    public $strDescription;
    public $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los departamentos dels bd 
    public function selectRegistros()
    {
        $sql = "SELECT id_compensation,name,description,status, CONCAT(DAY(date_create), ' de ', 
        CASE MONTH(date_create)
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
        END, ' del ', YEAR(date_create)) AS create_date,DATE_FORMAT(date_create, '%h:%i:%s %p') AS time_create FROM compensations WHERE status != 0";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para insertar registros
    public function insertCompensation(string $name, string $description, int $status)
    {
        $this->strCompensation = $name;
        $this->strDescription = $description;
        $this->intStatus = $status;

        $sql = "SELECT * FROM compensations WHERE name = '{$this->strCompensation}'";
        $request = $this->select_All($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO compensations(name,description,status,date_create) VALUES (?,?,?,DATE_SUB(NOW(), INTERVAL 5 HOUR))";
            $arrData = array($this->strCompensation, $this->strDescription, $this->intStatus);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            return 0;
        }
        return $return;
    }

    //Metodo para extraer informacion del registro
    public function selectCompensation(int $id_compensation)
    {
        $this->intIdCompensation = $id_compensation;
        $sql = "SELECT id_compensation, name, description, status FROM compensations WHERE id_compensation = $this->intIdCompensation";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para actualizar el registro
    public function updateCompensation(int $id_compensation, string $name, string $description, int $status)
    {
        $this->intIdCompensation = $id_compensation;
        $this->strCompensation = $name;
        $this->strDescription = $description;
        $this->intStatus = $status;

        $sql = "SELECT * FROM compensations WHERE (name = '{$this->strCompensation}' AND id_compensation != $this->intIdCompensation)";
        $request = $this->select_All($sql);
        if (empty($request)) {
            $sql = "UPDATE compensations SET name = ?, description = ?, status = ? WHERE id_compensation = $this->intIdCompensation";
            $arrData = array($this->strCompensation, $this->strDescription, $this->intStatus);
            $request = $this->update($sql, $arrData);
        } else {
            $request = 0;
        }
        return $request;
    }

    //Metodo para eliminar el registro
    public function deleteCompensations(int $id_compensation)
    {
        $this->intIdCompensation = $id_compensation;
        $sql = "UPDATE compensations SET status = ? WHERE id_compensation = ?";
        $arrData = array(0, $this->intIdCompensation);
        $request = $this->update($sql, $arrData);
        if ($request === true) {
            return 'ok';
        } else {
            return 'error';
        }
    }
}

