<?php
class Reportes extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        sessionStart();
        //session_regenerate_id(true);
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/login');
        }
        //getPermisos(7);
    }

    public function Reportes()
    {
        session_regenerate_id(true);
        $data['page_title'] = "Statistics";
        $data['page_main'] = "Statistics";
        $data['page_name'] = "Statistics";
        $data['page_functions_js'] = "funciones_reporte.js";
        $this->views->getView($this, "reportes", $data);
    }

    //Metodo para calcular "el total de clasificaciones"
    public function getClasificacionesOne()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $quejasXdepa = $this->model->calculoClasificacionOne($startDate, $endDate);
        echo json_encode($quejasXdepa);
    }

    //Metodo para calcular "el total de clasificaciones"
    public function getClasificacionesTwo()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $quejasXdepa = $this->model->calculoClasificacionTwo($startDate, $endDate);
        echo json_encode($quejasXdepa);
    }

    //Metodo para calcular "top 5 de las quejas mas concurrentes diarias"
    public function getQuejasDiarias()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $quejasDiarias = $this->model->calculoQuejasDiarias($startDate, $endDate);

        echo json_encode($quejasDiarias);
    }

    //Metodo para calcular "top 5 quejas por departamento"
    public function getQuejasDepartamento()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $quejasDepartamento = $this->model->calculoQuejasDepartamento($startDate, $endDate);
        echo json_encode($quejasDepartamento);
    }

    //Metodo para calcular "top 5 de los departamentos con mas quejas"
    public function getDepartamentosQuejas()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $departamentosQuejas = $this->model->calculoDepartamentosQuejas($startDate, $endDate);
        echo json_encode($departamentosQuejas);
    }

    //Metodo para calcular el tipo de huesped
    public function getTipoHuesped()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $tipoHuesped = $this->model->calculoTipoHuesped($startDate, $endDate);
        echo json_encode($tipoHuesped);
    }

    //Metodo para calcular "el total de quejas por departamento"
    public function getQuejasporDepartamento()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $quejasXdepa = $this->model->calculoQuejas($startDate, $endDate);
        echo json_encode($quejasXdepa);
    }

    //Metodo para calcular los lugares con mas quejas
    public function getLugares()
    {
        $startDate = isset($_GET['startDate']) ? $_GET['startDate'] : null;
        $endDate = isset($_GET['endDate']) ? $_GET['endDate'] : null;

        $Lugar = $this->model->calculoLugar($startDate, $endDate);
        echo json_encode($Lugar);
    }

}
