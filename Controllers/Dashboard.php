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
        $data['page_title'] = "Dashboard";
        $data['page_main'] = "Dashboard";
        $data['page_name'] = "dashboard";
        $data['page_functions_js'] = "function_dashboard.js";
        $this->views->getView($this, "dashboard", $data);
    }

    //Metodo para calcular el numero de girs
    public function getContadorGirs()
    {
        $arrData = $this->model->selectContadoresGirs();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Metodo para calcular el numero de girs = SCG
    public function getContadorSCG()
    {
        $arrData = $this->model->selectContadoresSCG();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Metodo para calcular el numero de girs = Possible auditor
    public function getContadorPA()
    {
        $arrData = $this->model->selectContadoresAuditor();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Metodo para calcular el numeor de usuarios
    public function getContadorUsuarios()
    {
        $arrData = $this->model->selectContadoresUsuarios();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Metodo para calcular registros Low
    public function getLow()
    {
        $arrData = $this->model->selectLow();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Metodo para caluclar registros Medium
    public function getMedium()
    {
        $arrData = $this->model->selectMedium();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Metodo para caluclar registros High
    public function getHigh()
    {
        $arrData = $this->model->selectHigh();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Metodo para caluclar registros InStay
    public function getInStay()
    {
        $arrData = $this->model->selectInStay();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Metodo para caluclar registros Informative
    public function getInformative()
    {
        $arrData = $this->model->selectInformative();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Metodo para caluclar registros Informative
    public function getWowMoment()
    {
        $arrData = $this->model->selectWowMoment();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrReponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrReponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Metodo para calcular registros In House
    public function getInHouse()
    {
        $arrData = $this->model->selectInHouse();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            //En caso contrario imprimira el arreglo de datos
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Metodo para calcular registros Special Care Guest
    public function getSpecialGuest()
    {
        $arrData = $this->model->selectSpecialGuest();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Metodo para calcular registros Due Out
    public function getDueOut()
    {
        $arrData = $this->model->selectDueOut();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Metodo para calcular registros Due Out
    public function getPossibleAuditor()
    {
        $arrData = $this->model->selectPossibleAuditor();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Metodo para calcular Total de Gir por Mes y nivel
    public function getTotalGir()
    {
        $arrData = $this->model->selectTotalGirs();
        //Si el arreglo esta vacio mostrara un msj de error
        if (empty($arrData)) {
            $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
        } else {
            $arrResponse = array('status' => true, 'data' => $arrData);
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
}
