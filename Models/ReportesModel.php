<?php

class ReportesModel extends Mysql
{

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para calcular "total de clasificaciones"
    public function calculoClasificacionOne($startDate = null, $endDate = null)
    {
        $sql = "SELECT 
    CASE 
        WHEN clasificacion = 'Cleanliness & Condition' THEN 'Cleanliness & Condition' 
        WHEN clasificacion = 'Courtesy & Manners' THEN 'Courtesy & Manners' 
        WHEN clasificacion = 'Efficiency' THEN 'Efficiency' 
        WHEN clasificacion = 'Food & Beverage Quality' THEN 'Food & Beverage Quality' 
        WHEN clasificacion = 'Graciousness, Thoughtfulness & Sense of Personalized Service' THEN 'Graciousness, Thoughtfulness & Sense of Personalized Service' 
        WHEN clasificacion = 'Guest Comfort & Convenience' THEN 'Guest Comfort & Convenience' 
        WHEN clasificacion = 'Sense of Luxury' THEN 'Sense of Luxury' 
        ELSE NULL END AS nombre, COUNT(idGir) as total FROM girs WHERE status = 1";
        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(fecha) <= '$endDate'";
        }
        $sql .= " GROUP BY clasificacion";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular "total de clasificaciones"
    public function calculoClasificacionTwo($startDate = null, $endDate = null)
    {
        $sql = "SELECT 
    CASE 
        WHEN clasificacion = 'Staff Appearance' THEN 'Staff Appearance' 
        WHEN clasificacion = 'Technical Execution, Skill & Knowledge' THEN 'Technical Execution, Skill & Knowledge' 
        WHEN clasificacion = 'Wellness' THEN 'Wellness' 
        WHEN clasificacion = 'Accident' THEN 'Accident' 
        WHEN clasificacion = 'Food restriction/preference' THEN 'Food restriction/preference' 
        WHEN clasificacion = 'illness' THEN 'illness'
        WHEN clasificacion = 'Possible Auditor' THEN 'Possible Auditor'  
        ELSE NULL END AS nombre, COUNT(idGir) as total FROM girs WHERE status = 1";
        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(fecha) <= '$endDate'";
        }
        $sql .= " GROUP BY clasificacion";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular "top 5 de las quejas mas concurrentes"
    public function calculoQuejasDiarias($startDate = null, $endDate = null)
    {
        $sql = "SELECT q.idQueja, q.nombre, COUNT(g.idGir) AS total_registros FROM girs g JOIN quejas q ON g.quejaid = q.idQueja WHERE g.status != 0";
        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(g.fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(g.fecha) <= '$endDate'";
        }
        // Agrupar y ordenar los resultados
        $sql .= " GROUP BY q.idQueja, q.nombre ORDER BY total_registros DESC LIMIT 5";
        // Ejecutar la consulta SQL y devolver los resultados
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular "Top 5 de las quejas mas concurrentes relacionado a los departamentos"
    public function calculoQuejasDepartamento($startDate = null, $endDate = null)
    {
        $sql = "SELECT d.nombre AS departamento, q.nombre AS queja, COUNT(*) AS total_quejas FROM girs g JOIN quejas q ON g.quejaid = q.idQueja JOIN departamento d ON g.departamentoid = d.idDepartamento WHERE g.status != 0";

        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(g.fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(g.fecha) <= '$endDate'";
        }
        // Agrupar y ordenar los resultados
        $sql .= " GROUP BY d.idDepartamento, q.idQueja ORDER BY total_quejas DESC LIMIT 5";
        // Ejecutar la consulta SQL y devolver los resultados
        $request = $this->select_All($sql);
        return $request;
    }


    //Metodo para calculoar "Top 5 de los departamentos con mas quejas"
    public function calculoDepartamentosQuejas($startDate = null, $endDate = null)
    {
        $sql = "SELECT d.idDepartamento, d.nombre, COUNT(g.idGir) as total_registros FROM girs g JOIN departamento d ON g.departamentoid = d.idDepartamento WHERE g.status != 0";
        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(g.fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(g.fecha) <= '$endDate'";
        }
        // Agrupar y ordenar los resultados
        $sql .= " GROUP BY d.idDepartamento, d.nombre ORDER BY total_registros DESC LIMIT 5";
        // Ejecutar la consulta SQL y devolver los resultados
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el tipo de huesped
    public function calculoTipoHuesped($startDate = null, $endDate = null)
    {
        $sql = "SELECT 
        CASE 
            WHEN TipoGir = 'Due Out' THEN 'Due Out' 
            WHEN TipoGir = 'In house' THEN 'In house' 
            WHEN TipoGir = 'Special Care Guest' THEN 'Special Care Guest' 
            WHEN TipoGir = 'Possible auditor' THEN 'Possible auditor' 
            ELSE NULL END AS categoria, COUNT(idGir) as total FROM girs WHERE status = 1";
        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(fecha) <= '$endDate'";
        }
        $sql .= " GROUP BY TipoGir";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular "el total de quejas por departamento"
    public function calculoQuejas($startDate = null, $endDate = null)
    {
        $sql = "SELECT d.idDepartamento, d.nombre, COUNT(g.idGir) AS total_registros FROM girs g JOIN departamento d ON g.departamentoid = d.idDepartamento WHERE g.status != 0 ";
        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(g.fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(g.fecha) <= '$endDate'";
        }
        $sql .= " GROUP BY d.idDepartamento, d.nombre ORDER BY total_registros DESC LIMIT 5";
        // Ejecutar la consulta SQL y devolver los resultados
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el total de lugares con mas quejas
    public function calculoLugar($startDate = null, $endDate = null)
    {
        $sql = "SELECT l.idLugar, l.nombre, COUNT(g.idGir) as total_registros FROM girs g JOIN lugarqueja l ON g.lugarQuejaid = l.idLugar WHERE g.status != 0";
        // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
        if ($startDate) {
            $sql .= " AND DATE(g.fecha) >= '$startDate'";
        }
        // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
        if ($endDate) {
            $sql .= " AND DATE(g.fecha) <= '$endDate'";
        }
        // Agrupar y ordenar los resultados
        $sql .= " GROUP BY l.idLugar, l.nombre ORDER BY total_registros DESC LIMIT 5";
        // Ejecutar la consulta SQL y devolver los resultados
        $request = $this->select_All($sql);
        return $request; 
    }

    //Metodo para calcular el porcentaje de villas external por semana
    public function selectPorcentajeExternal()
    {
        $sql = "SELECT Week(fecha) AS semana, COUNT(idGir) as total_registros, SUM(CASE WHEN villa = 'External' THEN 1 ELSE 0 END) AS total_Alto, IFNULL(SUM(CASE WHEN villa = 'External' THEN 1 ELSE 0 END) / NULLIF(COUNT(idGir), 0) * 100, 0) as porcentaje_External FROM girs WHERE status = 1 AND YEAR(fecha) = YEAR(CURDATE()) AND WEEK(fecha) = WEEK(CURDATE()) GROUP BY semana ORDER BY semana";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el porcentaje de villas external por semana
    public function selectPorcentajeSeveral()
    {
        $sql = "SELECT Week(fecha) AS semana, COUNT(idGir) as total_registros, SUM(CASE WHEN villa = 'Several' THEN 1 ELSE 0 END) AS total_Alto, IFNULL(SUM(CASE WHEN villa = 'Several' THEN 1 ELSE 0 END) / NULLIF(COUNT(idGir), 0) * 100, 0) as porcentaje_Several FROM girs WHERE status = 1 AND YEAR(fecha) = YEAR(CURDATE()) AND WEEK(fecha) = WEEK(CURDATE()) GROUP BY semana ORDER BY semana";
        $request = $this->select_All($sql);
        return $request;
    }
}
