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

    //Metodo para calcular registros Low
    public function selectLow()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        // Ajustar la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));

        // Obtener la fecha de inicio y fin del período actual (desde las 12:00 am hasta las 7:00 am del siguiente día)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));

        $sql = "SELECT COUNT(idGir) as contadorLow FROM girs WHERE status = 1 AND nivel = 'Low' AND (
                        -- Registros desde las 12:00 am del día actual hasta las 7:00 am del siguiente día
                        (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
                    )";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular registros Medium
    public function selectMedium()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        //Ajustamos la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));
        //Obtenemos la fecha de inicio y fin del periodo actual (desde las 12:00 am hasta las 7:00 am del dia siguiente)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorMedium From girs WHERE status = 1 AND nivel = 'Medium' AND (
            -- Registros desde las 12:00 am del dia actual hasta las 7:00 am del dia siguiente
            (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
        )";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular registros High
    public function selectHigh()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        //Ajustamos la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));
        //Obtenemos la fecha de inicio y fin del periodo actual (desde las 12:00 am hasta las 7:00 am del dia siguiente)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorHigh From girs WHERE status = 1 AND nivel = 'High' AND (
            -- Registros desde las 12:00 am del dia actual hasta las 7:00 am del dia siguiente
            (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
        )";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros InStay
    public function selectInStay()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        //Ajustamos la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));
        //Obtenemos la fecha de inicio y fin del periodo actual (desde las 12:00 am hasta las 7:00 am del dia siguiente)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorInStay From girs WHERE status = 1 AND nivel = 'In stay' AND (
            -- Registros desde las 12:00 am del dia actual hasta las 7:00 am del dia siguiente
            (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
        )";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular registros InStay
    public function selectInformative()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        //Ajustamos la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));
        //Obtenemos la fecha de inicio y fin del periodo actual (desde las 12:00 am hasta las 7:00 am del dia siguiente)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorInformative From girs WHERE status = 1 AND nivel = 'Informative' AND (
            -- Registros desde las 12:00 am del dia actual hasta las 7:00 am del dia siguiente
            (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
        )";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros InStay
    public function selectWowMoment()
    {
        $fecha_actual = date('Y-m-d H:i:s');
        //Ajustamos la fecha y hora actual restando 5 horas
        $fecha_actual_ajustada = date('Y-m-d H:i:s', strtotime('-5 hours', strtotime($fecha_actual)));
        //Obtenemos la fecha de inicio y fin del periodo actual (desde las 12:00 am hasta las 7:00 am del dia siguiente)
        $fecha_inicio_periodo = date('Y-m-d', strtotime($fecha_actual_ajustada));
        $fecha_fin_periodo = date('Y-m-d', strtotime('+1 day', strtotime($fecha_inicio_periodo)));
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorWowMoment From girs WHERE status = 1 AND nivel = 'Wow moment' AND (
            -- Registros desde las 12:00 am del dia actual hasta las 7:00 am del dia siguiente
            (fecha >= '$fecha_inicio_periodo' AND fecha < '$fecha_fin_periodo' + INTERVAL 7 HOUR)
        )";
        $request = $this->select_All($sql);
        return $request;
    }
}
