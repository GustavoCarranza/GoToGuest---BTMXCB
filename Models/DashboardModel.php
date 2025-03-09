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
        $sql = "SELECT COUNT(idGir) as contadorGirs FROM girs WHERE status = 1 
            AND estadoGir = 'Open' ";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el numero de girs = SCG
    public function selectContadoresSCG()
    {
        $sql = "SELECT COUNT(idGir) as contadorSCG FROM girs WHERE status = 1 AND TipoGir = 'Special Care Guest'AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular el numero de girs = Possible auditor
    public function selectContadoresAuditor()
    {
        $sql = "SELECT COUNT(idGir) as contadorAuditor FROM girs WHERE status = 1 AND TipoGir = 'Possible auditor' AND estadoGir = 'Open'";
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
        $sql = "SELECT COUNT(idGir) as contadorLow FROM girs WHERE status = 1 AND nivel = 'Low' AND estadoGir = 'Open' ";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular registros Medium
    public function selectMedium()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorMedium From girs WHERE status = 1 AND nivel = 'Medium' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular registros High
    public function selectHigh()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorHigh From girs WHERE status = 1 AND nivel = 'High' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros InStay
    public function selectInStay()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorInStay From girs WHERE status = 1 AND nivel = 'In stay' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para calcular registros Informative
    public function selectInformative()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorInformative From girs WHERE status = 1 AND nivel = 'Informative' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros WowMoment
    public function selectWowMoment()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorWowMoment From girs WHERE status = 1 AND nivel = 'Wow moment' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros InHouse
    public function selectInHouse()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorInHouse From girs WHERE status = 1 AND TipoGir = 'In house' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros Special Care Guest
    public function selectSpecialGuest()
    {
        //Creamos la consulta 
        $sql = "SELECT COUNT(idGir) as contadorSpecialGuest From girs WHERE status = 1 AND TipoGir = 'Special Care Guest' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros Due Out
    public function selectDueOut()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorDueOut From girs WHERE status = 1 AND TipoGir = 'Due Out' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular registros Possible Auditor
    public function selectPossibleAuditor()
    {
        //Creamos la consulta
        $sql = "SELECT COUNT(idGir) as contadorPossibleAuditor FROM girs WHERE status = 1 AND TipoGir = 'Possible auditor' AND estadoGir = 'Open'";
        $request = $this->select_All($sql);
        return $request;
    }
    //Metodo para calcular total de Gir por mes 
    public function selectTotalGirs()
    {
        $sql = "SELECT YEAR(fecha) AS fecha_gir, MONTH(fecha) AS mes_gir, COUNT(*) AS total, 
            SUM(CASE WHEN nivel = 'Low' THEN 1 ELSE 0 END) AS total_low,
            SUM(CASE WHEN nivel = 'Medium' THEN 1 ELSE 0 END) AS total_Medium,
            SUM(CASE WHEN nivel = 'High' THEN 1 ELSE 0 END) AS total_High,
            SUM(CASE WHEN nivel = 'In stay' THEN 1 ELSE 0 END) AS total_inStay,
            SUM(CASE WHEN nivel = 'Informative' THEN 1 ELSE 0 END) AS total_Informative,
            SUM(CASE WHEN nivel = 'Wow moment' THEN 1 ELSE 0 END) AS total_WoowMoment
            FROM girs GROUP BY YEAR(fecha), MONTH(fecha) ORDER BY fecha_gir ASC, mes_gir ASC";
        $request = $this->select_All($sql);
        return $request;
    }
}
