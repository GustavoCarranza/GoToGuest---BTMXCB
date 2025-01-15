<?php
class DashboardModel extends Mysql
{

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para calcular el numero de girs por dia 
    public function selectContadoresGirs()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT COUNT(idGir) as contadorGirs FROM girs WHERE status = 1 
            AND (
                -- Registros desde las 12:00 am del día actual hasta las 7:00 am del siguiente día
                (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
            )";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el numero de girs = SCG
    public function selectContadoresSCG()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT COUNT(idGir) as contadorSCG FROM girs WHERE status = 1 AND TipoGir = 'Special Care Guest'AND (
                    -- Registros desde las 12:00 am del día actual hasta las 7:00 am del siguiente día
                    (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
                )";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el numero de girs = Possible auditor
    public function selectContadoresAuditor()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT COUNT(idGir) as contadorAuditor FROM girs WHERE status = 1 AND TipoGir = 'Possible auditor' AND (
                        -- Registros desde las 12:00 am del día actual hasta las 7:00 am del siguiente día
                        (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
                    )";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el numero de usuarios
    public function selectContadoresUsuarios()
    {
        $sql = "SELECT COUNT(idUsuario) as contadorUsuarios FROM usuarios WHERE status = 1";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el total de estados
    public function calculoEstados()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT CASE WHEN estadoGir = 'Closed' THEN 'Closed' WHEN estadoGir = 'Open' THEN 'Open' ELSE NULL END AS estado, COUNT(idGir) as total FROM girs WHERE status != 0 AND (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR) GROUP BY estado";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el total de categorias
    public function calculoCategoria()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT CASE 
                        WHEN categoria = 'Service' THEN 'Service' 
                        WHEN categoria = 'Product' THEN 'Product' 
                        WHEN categoria = 'Informative' THEN 'Informative' 
                        ELSE NULL END AS categoria, COUNT(idGir) as total FROM girs WHERE status != 0 AND (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR) GROUP BY categoria";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el total de niveles
    public function calculoNivel()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT nivel, COUNT(idGir) as total FROM girs WHERE status = 1 AND (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR) GROUP BY nivel ORDER BY FIELD(nivel, 'Low', 'Medium', 'High', 'In stay', 'Informative', 'Wow moment')";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el total de tipo de huesped
    public function calculoHuesped()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT TipoGir, COUNT(idGir) as total FROM girs WHERE status = 1 AND (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR) GROUP BY tipoGir ORDER BY FIELD(TipoGir, 'In house', 'Due Out')";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para hacer el calculo en los registros de compensacion
    public function selectRegistrosCompensacion()
    {
        $sql = "SELECT g.idGir, g.compensacion, g.departamentoid, d.idDepartamento, d.nombre as nombreDepartamento, DATE_FORMAT(g.fecha, '%d/%m/%Y') as fecha,  CONCAT('$', SUM(g.compensacion), ' ' , 'dolares') AS sumaCompensacion FROM girs g INNER JOIN departamento d ON g.departamentoid = d.idDepartamento WHERE g.status = 1 GROUP BY DATE(g.fecha), g.departamentoid ORDER BY DATE(g.fecha) DESC";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el total de compensacion por departamento
    public function CalculoCompensacion($startDate = null, $endDate = null)
{
    $sql = "SELECT d.idDepartamento, d.nombre as nombre, SUM(CAST(REGEXP_REPLACE(g.compensacion, '[^0-9.-]', '') AS DECIMAL)) as totalCalculo 
            FROM girs g 
            INNER JOIN departamento d ON g.departamentoid = d.idDepartamento 
            WHERE g.status != 0";
    
    // Si se proporciona una fecha de inicio, agregar condición para incluir solo registros después o en la fecha de inicio
    if ($startDate) {
        $sql .= " AND DATE(fecha) >= '$startDate'";
    }
    // Si se proporciona una fecha de fin, agregar condición para incluir solo registros antes o en la fecha de fin
    if ($endDate) {
        $sql .= " AND DATE(fecha) <= '$endDate'";
    }
    
    $sql .= " GROUP BY g.departamentoid, nombre 
              ORDER BY totalCalculo DESC 
              LIMIT 5";
              
    $request = $this->select_All($sql);
    return $request;
}


    //Metodo para calcular el porcentaje de woow moment por semana 
    public function selectPorcentajeMomento()
    {

        $sql = "SELECT WEEK(fecha) AS semana, COUNT(idGir) AS total_registros, SUM(CASE WHEN nivel = 'Wow moment' THEN 1 ELSE 0 END) AS total_woow_moment,IFNULL(SUM(CASE WHEN nivel = 'Wow moment' THEN 1 ELSE 0 END) / NULLIF(COUNT(idGir), 0) * 100, 0) AS porcentaje_woow_moment FROM girs WHERE status = 1 AND YEAR(fecha) = YEAR(CURDATE()) AND WEEK(fecha) = WEEK(CURDATE()) GROUP BY semana ORDER BY semana";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el procentaje de Alto por semana
    public function selectPorcentajeAlto()
    {
        $sql = "SELECT Week(fecha) AS semana, COUNT(idGir) as total_registros, SUM(CASE WHEN nivel = 'Low' THEN 1 ELSE 0 END) AS total_Alto, IFNULL(SUM(CASE WHEN nivel = 'Low' THEN 1 ELSE 0 END) / NULLIF(COUNT(idGir), 0) * 100, 0) as porcentaje_Alto FROM girs WHERE status = 1 AND YEAR(fecha) = YEAR(CURDATE()) AND WEEK(fecha) = WEEK(CURDATE()) GROUP BY semana ORDER BY semana";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metoto para calcular el procentaje de alergias por semana
    public function selectPorcentajeAlergias()
    {
        $sql = "SELECT WEEK(fecha) as semana, COUNT(idGir) as total_registros, SUM(CASE WHEN quejaid = '18' THEN 1 ELSE 0 END) AS total_Alergias, IFNULL(SUM(CASE WHEN quejaid = '18' THEN 1 ELSE 0 END) / NULLIF(COUNT(idGir), 0) * 100, 0) as porcentaje_Alergia FROM girs WHERE status = 1 AND YEAR(fecha) = YEAR(CURDATE()) AND WEEK(fecha) = WEEK(CURDATE()) GROUP BY semana ORDER BY semana";
        $request = $this->select_All($sql);
        return $request;
    }
}
