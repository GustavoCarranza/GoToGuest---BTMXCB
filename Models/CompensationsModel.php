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
}

