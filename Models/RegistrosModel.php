<?php

class registrosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para obtener los registos Low
    public function selectLow()
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, 
        d.idDepartamento, d.nombre as nombreDepartamento, 
        l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, 
        DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
        DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, 
        DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  
        DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir 
    FROM girs g 
    INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
    INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
    INNER JOIN quejas q ON g.quejaid = q.idQueja 
    WHERE g.status = 1 
    AND g.nivel = 'Low' 
    AND DATE(g.fecha) = CURDATE()";  // Se agrega el filtro para que sea solo del día de hoy

        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para obtener los registos Medium
    public function selectMedium()
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, 
        d.idDepartamento, d.nombre as nombreDepartamento, 
        l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, 
        DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
        DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, 
        DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  
        DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir 
    FROM girs g 
    INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
    INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
    INNER JOIN quejas q ON g.quejaid = q.idQueja 
    WHERE g.status = 1 
    AND g.nivel = 'Medium' 
    AND DATE(g.fecha) = CURDATE()";  // Se agrega el filtro para que sea solo del día de hoy

        $request = $this->select_All($sql);
        return $request;
    }
    
    //Metodo para obtener los registos High
    public function selectHigh()
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, 
        d.idDepartamento, d.nombre as nombreDepartamento, 
        l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, 
        DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
        DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, 
        DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  
        DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir 
    FROM girs g 
    INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
    INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
    INNER JOIN quejas q ON g.quejaid = q.idQueja 
    WHERE g.status = 1 
    AND g.nivel = 'High' 
    AND DATE(g.fecha) = CURDATE()";  // Se agrega el filtro para que sea solo del día de hoy

        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para obtener los registos High
    public function selectInStay()
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, 
        d.idDepartamento, d.nombre as nombreDepartamento, 
        l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, 
        DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
        DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, 
        DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  
        DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir 
    FROM girs g 
    INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
    INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
    INNER JOIN quejas q ON g.quejaid = q.idQueja 
    WHERE g.status = 1 
    AND g.nivel = 'In stay' 
    AND DATE(g.fecha) = CURDATE()";  // Se agrega el filtro para que sea solo del día de hoy

        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para obtener los registos High
    public function selectInformative()
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, 
        d.idDepartamento, d.nombre as nombreDepartamento, 
        l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, 
        DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
        DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, 
        DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  
        DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir 
    FROM girs g 
    INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
    INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
    INNER JOIN quejas q ON g.quejaid = q.idQueja 
    WHERE g.status = 1 
    AND g.nivel = 'Informative' 
    AND DATE(g.fecha) = CURDATE()";  // Se agrega el filtro para que sea solo del día de hoy

        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para obtener los registos Wow Moment
    public function selectWowMoment()
    {
        $sql = "SELECT 
        g.idGir, g.clasificacion, g.compensacion, g.apellidos, g.villa, g.departamentoid, g.lugarQuejaid, g.quejaid, g.descripcion, g.accionTomada, g.seguimiento, g.estadoGir, g.categoria, g.TipoGir, g.imagen, g.status, g.nivel, 
        d.idDepartamento, d.nombre as nombreDepartamento, 
        l.idLugar, l.nombre as nombreLugar, 
        q.idQueja, q.nombre as nombreQueja, 
        DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha, 
        DATE_FORMAT(g.salida, '%d/%m/%Y') as salida, 
        DATE_FORMAT(g.entrada, '%d/%m/%Y') as entrada,  
        DATE_FORMAT(g.fecha, '%h:%i:%s %p') AS horaGir 
    FROM girs g 
    INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
    INNER JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar 
    INNER JOIN quejas q ON g.quejaid = q.idQueja 
    WHERE g.status = 1 
    AND g.nivel = 'Wow moment' 
    AND DATE(g.fecha) = CURDATE()";  // Se agrega el filtro para que sea solo del día de hoy

        $request = $this->select_All($sql);
        return $request;
    }
}
