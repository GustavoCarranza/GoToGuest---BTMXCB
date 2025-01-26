<?php
class Dashboard extends Controllers
{
    public function __construct()
    {
        sessionStart();
        //session_regenerate_id(true);
        parent::__construct();
        //validar la variable de sesion una vez logueados que esta creada en el controlador Login
        //session_start();
        if (empty($_SESSION['login'])) {
            header('location: ' . BASE_URL() . '/Login');
        }
        //Esta funcion esta creada en el archivo de helpers el valor depende del modulo en el que estamos
        getPermisos(1);
    }

    public function dashboard()
    {
        session_regenerate_id(true);
        $data['page_title'] = "DQR - Dashboard";
        $data['page_main'] = "DQR - Dashboard";
        $data['page_name'] = "dashboard";
        $data['page_functions_js'] = "functions_dashboard.js";
        $this->views->getView($this, "dashboard", $data);
    }

    //Metodo para calcular el numero de girs
    public function getContadorGirs()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectContadoresGirs();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para calcular el numero de girs = SCG
    public function getContadorSCG()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectContadoresSCG();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para calcular el numero de girs = Possible auditor
    public function getContadorPA()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectContadoresAuditor();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para calcular el numeor de usuarios
    public function getContadorUsuarios()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectContadoresUsuarios();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para calcular el total de estados
    public function getEstados()
    {
        $estados = $this->model->calculoEstados();
        echo json_encode($estados);
    }

    //Metodo para calcular el total de categoria
    public function getCategoria()
    {
        $categoria = $this->model->calculoCategoria();
        echo json_encode($categoria);
    }

    //Metodo para calcular el total de tipo de huesped
    public function getHuesped()
    {
        $huesped = $this->model->calculoHuesped();
        echo json_encode($huesped);
    }

    //Metodo para calcular el total de nivel
    public function getNivel()
    {
        $estados = $this->model->calculoNivel();
        echo json_encode($estados);
    }

    //Prueba de compensacion
    public function getCompensacion()
    {
        if ($_SESSION['permisosModulo']['r']) {
            // Recuperar los datos de la base de datos
            $arrData = $this->model->selectRegistrosCompensacion();
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);

        die(); // Terminar el script después de enviar la respuesta
    }

    //Metodo para calculo de compensacion por departamento
    public function getCalculoCompensacion()
    {
        $startDate = isset($_GET['startDate1']) ? $_GET['startDate1'] : null;
        $endDate = isset($_GET['endDate1']) ? $_GET['endDate1'] : null;

        $arrData = $this->model->CalculoCompensacion($startDate, $endDate);
        echo json_encode($arrData);
    }

    //Metodo para calculoar el porcentaje de woow momento por semana
    public function getContadorMomento()
    {
        if ($_SESSION['permisosModulo']['r']) {
            $arrData = $this->model->selectPorcentajeMomento();
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Data not found');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    //Metodo para calcular el porcentaje de Alto por semana
    public function getContadorAlto()
    {
        if($_SESSION['permisosModulo']['r']){
            $arrData = $this->model->selectPorcentajeAlto();
            //Si el arreglo esta vacio, retorna a un error ya que no se obtuve una respuesta por parte del modelo
            if(empty($arrData)){
                $arrReponse = array('status' => false, 'msg' => 'Data not found');
            }
            //Si es caso contrario nos mostrara la respuesta recibida y la convertiremos a json para poder interpretar de lado del frontEnd
            else{
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
    //Metodo para calcular el procentaje de Alergias por semana
    public function getContadorAlergias()
    {
        if($_SESSION['permisosModulo']['r']){
            $arrData = $this->model->selectPorcentajeAlergias();
            //Si el arreglo esta vacio mostrara una alerta ya que no hay una respuesta por parte del modelo
            if(empty($arrData)){
                $arrReponse = array('status' => false, 'msg' => 'Data not found');
            }
            //Si hay respuesta nos dara el dato y lo convertimos en json para poder interpretarlo de lado del front
            else{
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
